<?php


require_once ('functions.php');
require_once('helpers.php');
require_once('init.php');
require_once('winner.php');

$categoriesContent = include_template('categories.php', [
    'categories' => getCategories($con)
]);

$pageContent = include_template('main.php', [
        'categories' => getCategories($con),
        'lots' => getLots($con)
    ]);

$layoutContent = include_template('layout.php', [
        'pageContent' => $pageContent,
        'userName' => $_SESSION['username'] ?? "",
        'categoriesContent' => $categoriesContent,
        'categories' => getCategories($con),
        'title' => 'Главная'
]);

print($layoutContent);


