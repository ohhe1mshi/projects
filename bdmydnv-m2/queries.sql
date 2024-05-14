INSERT INTO categories (nameCategory, code) VALUES
( 'Доски и лыжи', 'boards'),
( 'Крепления', 'attachment'),
('Ботинки', 'boots'),
('Одежда', 'clothing'),
('Инструменты', 'tools'),
('Разное', 'other');

INSERT INTO users (mail, nameUser, contact, password) VALUES
('bebebe@gmail.com', 'Клим', '89045678452', 'password1'),
('bababa@mail.com', 'Егор', '89035448919', 'password2'),
('bebebebababa@gmail.com', 'Анатолий', '89078218486', 'password3');

INSERT INTO lots (nameLot, image, startPrice, endDate, priceStep, lotCategory, author) VALUES
('2014 Rossignol District Snowboard', 'img/lot-1.jpg', 10999, '2023-10-01',500, 1, 1),
('DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', 159999, '2023-01-25',500, 1, 2),
('Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', 8000, '2023-10-04', 500, 2, 2),
('Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', 8000, '2023-10-02', 500, 2, 1),
('Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', 7500, '2023-10-03', 500, 4, 3),
('Маска Oakley Canopy', 'img/lot-6.jpg', 5400, '2023-10-01', 500, 6, 3);

INSERT INTO bets (priceBet, betUser, betLot) VALUES
(160499, 1, 2),
(160999, 2, 2),
(161499, 3, 2),
(8500, 3, 4),
(5900, 2, 6);

-- получить список всех категорий
SELECT nameCategory FROM categories;

-- получить cписок лотов, которые еще не истекли отсортированных по дате публикации,
-- от новых к старым. Каждый лот должен включать название, стартовую цену,
-- ссылку на изображение, название категории и дату окончания торгов
SELECT nameLot, startPrice, image, categories.nameCategory, endDate FROM lots
INNER JOIN categories ON lots.lotCategory = categories.id
WHERE endDate >= CURRENT_TIMESTAMP ORDER BY createDate DESC;

-- показать информацию о лоте по его ID. Вместо id категории должно выводиться
-- название категории, к которой принадлежит лот из таблицы категорий
SELECT nameLot, image, startPrice, endDate, lotCategory, users.nameUser FROM lots
INNER JOIN users ON lots.author = users.id
WHERE users.id = author AND lots.id = 6;


-- обновить название лота по его идентификатору
UPDATE lots
SET nameLot = 'Ботинки для сноуборда DC Mutiny Charcoal'
WHERE id = 4;

-- получить список ставок для лота по его идентификатору с сортировкой по дате.
-- Список должен содержать дату и время размещения ставки, цену, по
-- которой пользователь готов приобрести лот, название лота и имя пользователя,
-- сделавшего ставку
SELECT timeBet, priceBet, lots.nameLot, users.nameUser FROM bets, lots, users
WHERE lots.id = betLot and users.id = betUser and betLot = 2 ORDER BY timeBet DESC;



SELECT nameLot, image, startPrice, endDate, categories.nameCategory, description, priceStep, users.nameUser FROM lots
INNER JOIN categories ON lots.category = categories.id
WHERE lots.id = '$id';
