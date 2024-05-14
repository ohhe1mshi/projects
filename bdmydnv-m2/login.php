<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$requiredFieds = ['email', 'password'];
$errors = [];
$user = findUser($con, $_POST['email'] ?? "");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($requiredFieds as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } 
    }
    if (password_verify($_POST['password'], $user['password'] ?? "") === false || empty($user['mail'])) {
        $errors['user'] = 'Введён неправильный логин или пароль';
    }

    if (empty($errors)) {
        $_SESSION['username'] = $user['nameUser'];
        $_SESSION['userId'] = $user['id'];
        header('Location: /');
        exit();
    }
}
$errors = array_filter($errors);
$categories = getCategories($con);
$login_content = include_template('loginTemplate.php', [
    'categories' => $categories, 
    'errors' => $errors]);

$categoriesContent = include_template('categories.php', [
    'categories' => $categories]);

$layoutContent = include_template('layout.php', [
    'pageContent' => $login_content,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => $categories,
    'title' => 'Регистрация'
]);

print($layoutContent);