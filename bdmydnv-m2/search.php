<?php

require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$text = trim(getGetVal('search'));
$countPages = findNumberPages($con, $text);
$countPages = ceil($countPages[0] / 9);
if($text === "") {
    $pageContent = include_template('searchTemplate.php', [
    'categories' => getCategories($con),
    'lots' => []
    ]);
} else {
    $pageContent = include_template('searchTemplate.php', [
    'categories' => getCategories($con),
    'lots' => findLots($con, $text, $_GET['page'] ?? 1),
    'countPages' => $countPages
    ]);
}
$categoriesContent = include_template('categories.php', [
    'categories' => getCategories($con)
]);

$layoutContent = include_template('layout.php', [
    'pageContent' => $pageContent,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => getCategories($con),
    'title' => 'Поиск'
    ]);
print($layoutContent);
