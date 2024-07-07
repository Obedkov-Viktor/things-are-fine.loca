<?php
// auth.php
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'UserRepository.php';
require_once 'AuthManager.php';
require_once 'SessionManager.php';

$userRepository = new UserRepository($pdo);
$sessionManager = new SessionManager();
$authManager = new AuthManager($userRepository, $sessionManager);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($authManager->login($email, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $errors['auth'] = 'Неверный email или пароль';
    }
}

$pageTitle = 'Авторизация';
$pageContent = include_template('form_authorization.php', [
    'errors' => $errors,
]);

$layoutContent = include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'pageContent' => $pageContent,
]);

print($layoutContent);
