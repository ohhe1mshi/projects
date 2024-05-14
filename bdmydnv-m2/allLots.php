<?php

require_once('init.php');
require_once('functions.php');
require_once('helpers.php');
$categories = getCategories($con);
$category = getGetVal('category');
$countLots = findCategoryPages($con, $category);


if($countLots === 0) {
    $pageContent = include_template('searchTemplate.php', [
        'categories' => $categories,
        'lots' => []
        ]);
} else {
    $countPages = ceil($countLots[0] / 9);
    $pageContent = include_template('allLotsTemplate.php', [
        'categories' => $categories,
        'lots' => findCategoryLots($con, $category, (int)$_GET['page']),
        'countPages' => $countPages,
        'category' => $category
        ]);
}
$categoriesContent = include_template('categories.php', [
    'categories' => $categories
]);

$layoutContent = include_template('layout.php', [
    'pageContent' => $pageContent,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => $categories,
    'title' => $category]
);
print($layoutContent);
