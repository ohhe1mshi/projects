<?php

date_default_timezone_set('Asia/Yekaterinburg');
/**
* Делает из произвольного числа форматированное число для отображения цены продукта
*
* @param float $num Произвольное число
*
* @return string Форматированное число
*/
 function priceFormat(int $num): string
{
    return number_format($num, 0, "", " ") . " ₽";
}


/**
* Делает из даты массив из чисел для таймера обратного отчсета типа "Часы:Минуты"
*
* @param string $date Дата для преобразования
*
* @return array Массив из двух чисел
*/
function timeLeft(string $date): array
{
    $time = time();
    $timeExp = strtotime($date) + 3600 * 24;
    $diff = $timeExp - $time;

    $hours = str_pad(floor($diff / 3600), 2, "0", STR_PAD_LEFT);
    $minutes = str_pad(floor(($diff - $hours * 3600) / 60 + 1), 2, "0", STR_PAD_LEFT);
    return [$hours, $minutes];
}

/**
* Делает из даты массив из чисел для таймера типа "Часы:Минуты"
*
* @param string $date Дата для преобразования
*
* @return array Массив из двух чисел
*/
function reverseTimeLeft(string $date): array
{

    $secExp = strtotime($date);
    $timeExp = time() - $secExp;
    $hours = floor($timeExp / 3600);
    $minutes = floor(($timeExp - $hours * 3600) / 60 + 1);
    return [$hours, $minutes];
}

/**
* Получает из базы данных массив со всеми категориями
*
* @param mysqli $con Переменная для подключения к базе данных
*
* @return array Массив из категорий
*/
function getCategories(mysqli $con): array
{
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


/**
* Получает из базы данных массив со всеми лотами которые еще не достигли даты истечения
*
* @param mysqli $con Переменная для подключения к базе данных
*
* @return array Массив из лотов
*/
function getLots(mysqli $con): array
{
    $sql = "SELECT nameLot, lots.id, startPrice, image, categories.nameCategory, endDate FROM lots
            INNER JOIN categories ON lots.lotCategory = categories.id
            WHERE endDate >= CURRENT_DATE ORDER BY createDate DESC";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


/**
* Получает из базы данных массив с данными лота который выбрал пользователь
* Если лот был не найден, то передается пустой массив и объявляется ошибка 404
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $id Id лота
*
* @return array Пустой массив
* @return array Массив из данных лота
*/
function getLotInfo(mysqli $con, int $id): array
{
    $sql = "SELECT nameLot, image, startPrice, priceStep, description, endDate,lots.id, categories.nameCategory as category, users.nameUser as author from lots 
    LEFT JOIN categories ON lots.lotCategory = categories.id 
    LEFT JOIN users ON lots.author = users.id 
    where lots.id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 0) {
        http_response_code(404);
    }
    return mysqli_fetch_assoc($result) ?? [];
}


/**
* Добавляет в базу данных новый лот
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $fileUrl Путь к картинке лота
*/
function addNewLot(mysqli $con, string $fileUrl)
{
    $sql = "INSERT INTO lots (nameLot, image, startPrice, description, endDate, priceStep, lotCategory, author)
    VALUE (?, ?, ?, ?, ?, ?, (SELECT id FROM categories WHERE nameCategory = ?), ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssissisi', $_POST['lot-name'], $fileUrl, $_POST['lot-rate'], $_POST['message'], $_POST['lot-date'], $_POST['lot-step'], $_POST['category'], $_SESSION['userId']);
    mysqli_stmt_execute($stmt);
}


/**
* Возвращает определенные отправленные данные формы с методом POST
*
* @param string $name Имя параметра формы, данные которого нужно вернуть
*
* @return string Необходимые данные
*/
function getPostVal($name)
{
    return $_POST[$name] ?? "";
}



/**
* Добавляет в базу данных нового пользователя
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $email Почта пользователя
* @param string $password Пароль для входа на сайт (Хешированный)
* @param string $name Имя пользователя
* @param string $message Контактные данные пользователя
*/
function addUser(mysqli $con, string $email, string $password, string $name, string $message)
{
    $sql = "INSERT INTO users (nameUser, mail, password, contact)
    VALUE (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $password, $message);
    mysqli_stmt_execute($stmt);
}


/**
* Ищет в базе данных пользователя используя E-mail и возвращает его данные,
* если ничего не было найдено, то возвращяется пустой массив
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $email Почта пользователя
*
* @return array Массив из данных пользователя
* @return array Пустой массив
*/
function findUser(mysqli $con, string $email): array
{
    $sql = "SELECT mail, password, id, nameUser FROM users WHERE mail = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return [];
    }
}

/**
* Ищет в базе данных лоты, используя введеный пользователем текст и возвращает результаты запроса
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $text Запрос пользователя
* @param int $page Страница на которой находится пользователь, используется для шага индекса вывода лотов
*
* @return array Массив из результатов запроса
*/
function findLots(mysqli $con, string $text, int $page): array
{
    $offsetCounter = 0;
    $sql = "SELECT nameLot, lots.id, startPrice, image, categories.nameCategory, endDate, lots.author FROM lots
    INNER JOIN categories ON lots.lotCategory = categories.id
    WHERE MATCH (nameLot, description) AGAINST(? IN BOOLEAN MODE) AND lots.endDate >= DATE(NOW()) limit 9 offset ? ;";
    $offsetCounter = ($page - 1) * 9;
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'si', $text, $offsetCounter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}


/**
* Ищет и считает в базе данных количество лотов, используя введеный пользователем текст и возвращaет результаты подсчетов
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $text Запрос пользователя
*
* @return array Строка из одного элемента - результата подсчетов
*/
function findNumberPages(mysqli $con, string $text): array
{
    $sql = "SELECT COUNT(*) FROM lots 
    WHERE MATCH(nameLot, description) AGAINST(? IN BOOLEAN MODE) AND lots.endDate >= DATE(NOW())";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $text);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_row($result);
    } else {
        return [];
    }
}


/**
* Ищет в базе данных лоты, используя выбранную пользователем категорию и возвращaет результаты запроса
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $category Выбранная категория
* @param int $page Страница на которой находится пользователь, используется для шага индекса вывода лотов
*
* @return array Массив из результатов запроса
*/
function findCategoryLots(mysqli $con, string $category, int $page): array
{
    $offsetCounter = 0;
    $sql = "SELECT lots.nameLot, lots.startPrice, lots.image, categories.nameCategory, lots.endDate, lots.id, lots.author, (SELECT bets.priceBet FROM bets
    WHERE bets.betLot = lots.id ORDER BY bets.priceBet desc limit 1) as price FROM lots
    INNER JOIN categories ON lots.lotCategory = categories.id
    WHERE categories.nameCategory = ? and lots.lotCategory = (SELECT id FROM categories WHERE nameCategory = ?) AND lots.endDate >= DATE(NOW()) limit 9 offset ? ;";
    $offsetCounter = ($page - 1) * 9;
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssi', $category, $category, $offsetCounter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}


/**
* Ищет и считает в базе данных количество лотов используя выбранную пользователем категорию и возвращaет результаты подсчетов
*
* @param mysqli $con Переменная для подключения к базе данных
* @param string $category Выбранная категория
*
* @return array Массив из одного элемента - результата подсчетов
*/
function findCategoryPages(mysqli $con, string $category): array
{
    $sql = "SELECT COUNT(*) FROM lots
    inner join categories
    WHERE categories.nameCategory = ? and lots.lotCategory = (SELECT id FROM categories WHERE nameCategory = ?) AND lots.endDate >= DATE(NOW())";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $category, $category);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_row($result);
    } else {
        return [];
    }
}


/**
* Ищет в базе данных лоты на которые пользователь делал ставки и возвращaет результаты запроса
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $userId id пользователя
*
* @return array Массив из результатов запроса
*/
function findUserLots(mysqli $con, int $userId): array
{
    $sql = "SELECT lots.nameLot, lots.winner, lots.startPrice,
    lots.endDate, lots.image, categories.nameCategory, lots.id,
    bets.priceBet, bets.timeBet, bets.betUser, users.contact FROM lots
    INNER JOIN categories ON lots.lotCategory = categories.id
    INNER JOIN bets
    INNER JOIN users
    WHERE bets.betLot = lots.id and bets.betUser = ? and users.id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}


/**
* Добавляет в базу данных ставку
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $userId id пользователя
* @param int $lotId id лота
* @param int $cost Ставка пользователя
*/
function addBet(mysqli $con, int $userId, int $lotId, int $cost): void
{
    $sql = "INSERT INTO bets(priceBet, betLot, betUser)
    VALUE (?,?,?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'iii', $cost, $lotId, $userId);
    mysqli_stmt_execute($stmt);
}


/**
* Ищет в базе данных сделанные по определенному лоту ставки и возвращaет результаты запроса
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $lotId id лота
*
* @return array Массив из результатов запроса
*/
function findBetsLot(mysqli $con, int $lotId): array
{
    $sql = "SELECT users.nameUser, bets.priceBet, bets.timeBet FROM bets
    INNER JOIN users ON users.id = bets.betUser
    WHERE bets.betLot = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $lotId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

/**
* Ищет в базе данных сделанные по определенному лоту ставки и возвращaет наибольшую ставку (для выставления новой цены для лота)
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $lotId id лота
*
* @return array Массив из одного элемента - результата поиска ставки
*/
function findMaxBet(mysqli $con, int $lotId): array
{
    $sql = "SELECT bets.priceBet FROM bets
    WHERE bets.betLot = ? ORDER BY bets.priceBet desc limit 1";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $lotId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_row($result);
    } else {
        return [];
    }
}


/**
* Ищет в базе данных лоты с истеченным временем и возвращает их
*
* @param mysqli $con Переменная для подключения к базе данных
*
* @return array Массив из результатов запроса
*/
function findExpireLots(mysqli $con)
{
    $sql = "SELECT lots.nameLot, lots.endDate, lots.id, bets.timeBet, bets.priceBet, bets.betUser FROM lots
    INNER JOIN bets
    WHERE lots.endDate <= DATE(NOW())";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

/**
* Изменяет лот в базе данных, добавляя к нему победителя
*
* @param mysqli $con Переменная для подключения к базе данных
* @param int $lotId id лота
*/
function setWinner(mysqli $con, int $lotId): void
{
    $sql = "UPDATE lots
    SET winner = (SELECT bets.betUser FROM bets 
    WHERE bets.betLot = ? ORDER BY bets.priceBet desc limit 1)
     where lots.id = ?;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $lotId, $lotId);
    mysqli_stmt_execute($stmt);
}


/**
* Возвращaет определенные отправленные данные формы с методом GET
*
* @param string $name Имя параметра формы данные которого нужно вернуть
*
* @return string Необходимые данные
*/
function getGetVal(string $name): string
{
    return $_GET[$name] ?? "";
}
