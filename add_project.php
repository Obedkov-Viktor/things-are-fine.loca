<?php
// Подключаем необходимые файлы
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'ProjectRepository.php';
require_once 'AuthManager.php';
require_once 'UserRepository.php';
require_once 'SessionManager.php';

// Создаем экземпляры классов
$projectRepository = new ProjectRepository($pdo);
$userRepository = new UserRepository($pdo);
$authManager = new AuthManager($userRepository, new SessionManager());

// Проверяем, авторизован ли пользователь

if ($authManager->isLoggedIn()) {
    // Получаем текущего пользователя
    $user = $authManager->getCurrentUser();
    $userProjects = $projectRepository->getProjectsByUserId($user['id']);
    // Обрабатываем запрос на добавление проекта
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $projectName = $_POST['name'];

        // Создаем новый проект
        $projectRepository->createProject($projectName, $user['id']);

        // Перенаправляем пользователя на главную страницу
        header('Location: index.php');
        exit;
    }
    // Отображаем форму для добавления проекта
    $pageTitle = 'Добавление проекта';
    $pageContent = include_template('form-project.php', [
        'user' => $user,
        'userProjects' => $userProjects,
    ]);

    $layoutContent = include_template('layout.php', [
        'pageTitle' => $pageTitle,
        'pageContent' => $pageContent,
        'isLoggedIn' => $authManager->isLoggedIn(),
        'userName' => $user['name'],
    ]);

    print($layoutContent);
} else {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header('Location: login.php');
    exit;
}