<?php

require_once('functions.php');
require_once('init.php');
require_once('helpers.php');


$id = $_GET['id'] ?? 0;
$lotInfo = getLotInfo($con, $id);
$error = [];
$tempPrice = findMaxBet($con, $id);
if (isset($tempPrice[0])) {
    $lotInfo['price'] = $tempPrice[0];
}

$categoriesContent = include_template('categories.php', [
    'categories' => getCategories($con)
]);

if (http_response_code() === 404) {
    $lotContent = include_template('404.php', []);
    $title = "404";
} else {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(filter_var((int)$_POST['cost'], FILTER_VALIDATE_INT) && (int)$_POST['cost'] >= ($lotInfo['price'] ?? $lotInfo['priceBet']) + $lotInfo['priceStep']) {
            addBet($con, $_SESSION['userId'], $lotInfo['id'], $_POST['cost']);
            header("Location: /lot.php?id=$id");
            exit();
        } else {
            $error['cost'] = "Введенно число меньше ранее предложенного";
        }
    }
    $lotContent = include_template('lotTemplate.php', [
        'lotInfo' => $lotInfo,
        'betsInfo' => findBetsLot($con, $id),
        'error' => $error
    ]);
    $title = $lotInfo['nameLot'];
}


$layoutContent = include_template('layout.php', [
    'pageContent' => $lotContent,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => getCategories($con),
    'title' => $title
]);
print($layoutContent);
