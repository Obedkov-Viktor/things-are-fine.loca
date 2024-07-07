<?php
// Подключаем необходимые файлы
require_once 'helpers.php';
require_once 'db_connect.php';
require_once 'AuthManager.php';
require_once 'UserRepository.php';
require_once 'SessionManager.php';
require_once 'TaskRepository.php';
require_once 'ProjectRepository.php';

$taskRepository = new TaskRepository($pdo);
$projectRepository = new ProjectRepository($pdo);
$userRepository = new UserRepository($pdo);
$authManager = new AuthManager($userRepository, new SessionManager());

$errors = [];

if ($authManager->isLoggedIn()) {
    $user = $authManager->getCurrentUser();

    // Получаем проекты пользователя
    $userProjects = $projectRepository->getProjectsByUserId($user['id']);

    // Получаем задачи для каждого проекта
    $userTasks = [];
    foreach ($userProjects as $project) {
        $userTasks[$project['id']] = $taskRepository->getTasksByProjectId($project['id']);
    }

    // Обрабатываем запрос на добавление задачи
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $taskName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $projectId = filter_input(INPUT_POST, 'project', FILTER_SANITIZE_NUMBER_INT);
        $dateTerm = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $file = !empty($_FILES['file']['name']) ? $_FILES['file']['name'] : null;

        // Валидация
        if (empty($taskName)) {
            $errors['name'] = 'Название задачи не должно быть пустым.';
        }

        if (empty($projectId)) {
            $errors['project'] = 'Необходимо выбрать проект.';
        }

        if (!empty($dateTerm)) {
            // Проверка, соответствует ли дата формату ГГГГ-ММ-ДД
            $dateValid = preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTerm);
            if (!$dateValid) {
                $errors['date'] = 'Дата выполнения должна быть в формате ГГГГ-ММ-ДД.';
            }
        }
// Проверка и загрузка файла
        if (!empty($_FILES['file']['name'])) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($file);

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
//                $_SESSION['message'] = 'Файл успешно загружен.';
            } else {
                $errors['file'] = 'Не удалось загрузить файл.';
            }
        }
        if (count($errors) === 0) {
            // Создаем новую задачу
            $taskRepository->createTask($user['id'], $projectId, $taskName, $file, $dateTerm, $status);

            // Перенаправляем пользователя на главную страницу
            header('Location: index.php');
            exit;
        }
    }

    // Отображаем форму для добавления задачи
    $pageTitle = 'Добавление задачи';
    $pageContent = include_template('form-task.php', [
        'user' => $user,
        'userProjects' => $userProjects,
        'userTasks' => $userTasks,
        'errors' => $errors, // передаем ошибки в форму
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
?>