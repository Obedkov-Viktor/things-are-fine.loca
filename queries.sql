-- Создаем базу данных
CREATE DATABASE things_are_fine;

USE things_are_fine; -- Переключаемся на созданную базу данных

-- Создаем таблицу для Проектов
CREATE TABLE projects (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(255) NOT NULL,
                          created_by INT,
                          FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Создаем таблицу для Задач
CREATE TABLE tasks (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       created_date DATETIME NOT NULL,
                       status TINYINT DEFAULT 0,
                       title VARCHAR(255) NOT NULL,
                       file_link VARCHAR(255),
                       due_date DATE,
                       project_id INT,
                       FOREIGN KEY (project_id) REFERENCES projects(id),
                       author_id INT,
                       FOREIGN KEY (author_id) REFERENCES users(id)
);

-- Создаем таблицу для Пользователей
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       registration_date DATETIME NOT NULL,
                       email VARCHAR(255) UNIQUE NOT NULL,
                       name VARCHAR(255) NOT NULL,
                       password_hash CHAR(60) NOT NULL
);



-- Запросы на вставку данных
INSERT INTO projects (name) VALUES ('Входящие'), ('Учеба'), ('Работа'), ('Домашние дела'), ('Авто');
INSERT INTO users (username) VALUES ('user1'), ('user2');
INSERT INTO tasks (task, due_date, category, completed) VALUES
                                                            ('Собеседование в IT компании', STR_TO_DATE('03.06.2024', '%d.%m.%Y'), 'Работа', 0),
                                                            ('Выполнить тестовое задание', STR_TO_DATE('25.12.2024', '%d.%m.%Y'), 'Работа', 1),
                                                            ('Сделать задание первого раздела', STR_TO_DATE('21.12.2024', 'Учеба', 1),
                                                            ('Встреча с другом', STR_TO_DATE('22.12.2024', 'Входящие', 0),
                                                            ('Купить корм для кота', NULL, 'Домашние дела', 0),
                                                            ('Заказать пиццу', NULL, 'Домашние дела', 0);
-- Запросы на выборку данных
-- SELECT  *  FROM projects; -- Получить все проекты
-- SELECT  *  FROM users; -- Получить всех пользователей
-- SELECT  *  FROM tasks WHERE completed = 0 AND user_id IN (SELECT id FROM users WHERE username = 'user1'); -- Получить все активные задачи для пользователя user1
-- SELECT  *  FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE name = 'Работа') AND completed = 0; -- Получить все активные задачи для проекта Работа
-- UPDATE tasks SET completed = 1 WHERE task_id IN (SELECT id FROM tasks WHERE task = 'Собеседование в IT компании'); -- Пометить задачу как выполненную
-- UPDATE tasks SET task = 'Новая задача', due_date = '15.01.2025' WHERE task_id IN (SELECT id FROM tasks WHERE task = 'Собеседование в IT компании'); -- Обновить название задачи


Чтобы заполнить базу данных данными из существующих массивов, вы можете использовать следующие SQL-запросы:

-- Добавление списка проектов
INSERT INTO projects (name) VALUES ('Входящие'), ('Учеба'), ('Работа'), ('Домашние дела'), ('Авто');

-- Добавление пары пользователей
INSERT INTO users (registration_date, email, name, password_hash) VALUES
                                                                      ('2023-04-01', 'user1@example.com', 'User One', SHA2('password', 256)),
                                                                      ('2023-04-02', 'user2@example.com', 'User Two', SHA2('password', 256));

-- Добавление списка задач
INSERT INTO tasks (date_created, status, title, file_path, due_date, project_id) VALUES
                                                                                     ('2023-04-01', 0, 'Собеседование в IT компании', null, '2023-06-03', 3),
                                                                                     ('2023-04-01', 1, 'Выполнить тестовое задание', null, '2024-12-25', 3),
                                                                                     ('2023-04-01', 1, 'Сделать задание первого раздела', null, '2024-12-21', 2),
                                                                                     ('2023-04-01', 0, 'Встреча с другом', null, '2024-12-22', 1),
                                                                                     ('2023-04-01', 0, 'Купить корм для кота', null, null, 4),
                                                                                     ('2023-04-01', 0, 'Заказать пиццу', null, null, 4);


-- Эти запросы добавят данные в вашу базу данных, используя структуру таблиц,
-- которую вы определили ранее. Убедитесь, что столбцы и типы данных соответствуют тем, которые вы ожидаете.
--
-- Теперь давайте напишем запросы для манипуляции данными:

-- Получить список всех проектов для одного пользователя
SELECT p. *  FROM projects p JOIN tasks t ON p.id = t.project_id WHERE t.author = ? AND t.status = 1;

-- Получить список всех задач для одного проекта
SELECT t. *  FROM tasks t WHERE t.project_id = ?;

-- Пометить задачу как выполненную
UPDATE tasks SET status = 1 WHERE id = ?;

-- Обновить название задачи по её идентификатору
UPDATE tasks SET title = ? WHERE id = ?;

-- Эти запросы используют плейсхолдеры ? для параметров,
-- которые вы должны заменить на конкретные значения при выполнении запросов.
-- Например, для получения списка всех проектов для одного пользователя,
-- вы должны указать ID пользователя, а для получения списка всех задач для одного проекта - ID проекта.