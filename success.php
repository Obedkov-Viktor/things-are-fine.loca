<?php
session_start();
$pageTitle = 'Успешная регистрация';

$pageContent = include_template('success.php', [
    'userName' => $_SESSION['user_name'],
]);

$layoutContent = include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'pageContent' => $pageContent,
]);

print($layoutContent);