<?php

require_once('functions.php');
require_once('init.php');
require_once('helpers.php');

$options = ['options' => ['min_range' => 1]];

if(!isset($_SESSION["username"])) {
    http_response_code(403);
    $addContent = include_template("403.php", []);
    $title = "403";
} else {
    $requiredFieds = ["lot-name", "category", "message", "lot-rate", "lot-step", "lot-date"];
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($requiredFieds as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = "Поле не заполнено";
            }
        }

        if (!filter_var($_POST['lot-rate'], FILTER_VALIDATE_INT, $options)) {

            $errors["lot-rate"] = "Укажите правильное число";

        }

        if (!filter_var((int)$_POST['lot-step'], FILTER_VALIDATE_INT, $options)) {
            $errors["lot-step"] = "Укажите правильное число";
        }

        if ($_FILES['lot-img']['tmp_name'] !== "") {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileName = $_FILES['lot-img']['tmp_name'];
            $fileType = finfo_file($finfo, $fileName);
            print($fileType);
            if ($fileType !== 'image/png' && $fileType !== 'image/jpeg') {
                $errors['lot-img'] = "Загрузите картинку в формате jpeg или png";
            }
        } else {
            $errors['lot-img'] = "Загрузите картинку в формате jpeg или png";
        }


        if ((strtotime($_POST['lot-date']) - time() + (3600 * 24)) < (3600 * 24)) {
            $errors['lot-date'] = "Укажите правильную дату";
        }


        if (empty($errors)) {
            $fileName = $_FILES['lot-img']['name'];
            $filePath = __DIR__ . '/uploads/';
            $fileUrl = '/uploads/' . $fileName;
            move_uploaded_file($_FILES['lot-img']['tmp_name'], $filePath . $fileName);
            addNewLot($con, $fileUrl);
            $id = mysqli_insert_id($con);
            header("Location: /lot.php?id=$id");
            exit();
        }

    }
    $errors = array_filter($errors);

    $addContent = include_template('addTemplate.php', [
        'categories' => getCategories($con),
        'errors' => $errors
    ]);
}






$categories = getCategories($con);


$categoriesContent = include_template('categories.php', [
    'categories' => $categories
]);

$layoutContent = include_template('layout.php', [
    'pageContent' => $addContent,
    'userName' => $SESSION['username'] ?? "",
    'categoriesContent' => $categoriesContent,
    'categories' => $categories,
    'title' => 'Добавление лота'
]);



print($layoutContent);
