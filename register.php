<?php
// register.php
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
    $name = $_POST['name'];

    if ($userRepository->getUserByEmail($email)) {
        $errors['email'] = 'Пользователь с таким email уже существует';
    } else {
        $userId = $userRepository->createUser($email, $password, $name);
        $authManager->login($email, $password);
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'Регистрация';
$pageContent = include_template('form_registration.php', [
    'errors' => $errors,
]);

$layoutContent = include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'pageContent' => $pageContent,
]);

print($layoutContent);
