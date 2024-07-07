<?php
// guest.php
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'UserRepository.php';
require_once 'AuthManager.php';
require_once 'SessionManager.php';

$userRepository = new UserRepository($pdo);
$sessionManager = new SessionManager();
$authManager = new AuthManager($userRepository, $sessionManager);

if ($authManager->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$pageTitle = 'Страница для гостей';
$pageContent = include_template('guest.php', []);

$layoutContent = include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'pageContent' => $pageContent,
]);

print($layoutContent);
