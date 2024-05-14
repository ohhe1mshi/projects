<?php
require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$requiredFieds = ['email', 'password', 'name', 'message'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($requiredFieds as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } elseif ($field === 'email' && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введён неправильный e-mail';
        } elseif ($field === 'email' && !empty(findUser($con, $_POST['email']))) {
            $errors['email'] = 'Этот e-mail уже занят';
        }
    }

    if (empty($errors)) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        addUser($con, $_POST['email'], $password, $_POST['name'], $_POST['message']);
        header("Location: /login.php");
        exit();    
    }
}
$errors = array_filter($errors);
$categories = getCategories($con);
$signup_content = include_template('signUpTemplate.php', [
    'categories' => $categories, 
    'errors' => $errors]);

$categoriesContent = include_template('categories.php', [
    'categories' => $categories]);

$layoutContent = include_template('layout.php', [
    'pageContent' => $signup_content,
    'userName' => $_SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => $categories,
    'title' => 'Регистрация'
]);

print($layoutContent);
       