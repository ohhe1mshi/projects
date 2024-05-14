<?php

require_once('init.php');
require_once('functions.php');
require_once('helpers.php');
$categories = getCategories($con);

$pageContent = include_template('myBetsTemplate.php', [
    'categories' => $categories,
    'userLots' => findUserLots($con, (int)$_SESSION['userId'] ?? "" )
    ]);


$categoriesContent = include_template('categories.php', [
    'categories' => $categories
]);


$layoutContent = include_template('layout.php', [
    'pageContent' => $pageContent,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => $categories,
    'title' => 'Мои ставки'
    ]);
print($layoutContent);
