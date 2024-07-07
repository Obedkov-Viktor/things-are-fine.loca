<?php
// Подключение необходимых файлов и инициализация
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'UserRepository.php';
require_once 'AuthManager.php';
require_once 'SessionManager.php';

$userRepository = new UserRepository($pdo);
$sessionManager = new SessionManager();
$authManager = new AuthManager($userRepository, $sessionManager);

// Обработка выхода пользователя
if ($authManager->isLoggedIn()) {
    $authManager->logout();
    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}