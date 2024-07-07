<?php
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'UserRepository.php';
require_once 'AuthManager.php';
require_once 'SessionManager.php';
require_once 'ProjectRepository.php';
require_once 'TaskRepository.php';

$userRepository = new UserRepository($pdo);
$sessionManager = new SessionManager();
$authManager = new AuthManager($userRepository, $sessionManager);
$projectRepository = new ProjectRepository($pdo);
$taskRepository = new TaskRepository($pdo);

// Проверка авторизации пользователя
$isLoggedIn = $authManager->isLoggedIn();
$userName = null;
if ($isLoggedIn) {
    $user = $authManager->getCurrentUser();
    $userName = $user['name'];
    $projects = $projectRepository->getProjectsByUserId($user['id']);

// Получение количества задач для каждого проекта
    foreach ($projects as &$project) {
        $project['task_count'] = $taskRepository->countTasksByProjectId($project['id']);
    }

    // Фильтрация задач по выбранному проекту
    $selectedProjectId = isset($_GET['project_id']) ? intval($_GET['project_id']) : null;
    if ($selectedProjectId) {
        $tasks = $taskRepository->getTasksByProjectId($selectedProjectId);
    } else {
        $tasks = $taskRepository->getTasksByUserId($user['id']);
    }

    // Пропустить задачу, если она выполнена

    $pageTitle = 'Главная страница (авторизованный пользователь)';
    $pageContent = include_template('main.php', [
        'user' => $user,
        'projects' => $projects,
        'tasks' => $tasks,
    ]);
} else {
    $pageTitle = 'Главная страница (гость)';
    $pageContent = include_template('guest.php', []);
}

$layoutContent = include_template('layout.php', [
    'pageTitle' => $pageTitle,
    'pageContent' => $pageContent,
    'isLoggedIn' => $isLoggedIn,
    'userName' => $userName ?? '',
]);

print($layoutContent);

