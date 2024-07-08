<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $project) : ?>
                <li class="main-navigation__list-item <?= isset($selectedProjectId) && $selectedProjectId == $project['id'] ? 'main-navigation__list-item--active' : '' ?>">
                    <a class="main-navigation__list-item-link"
                       href="?project_id=<?= htmlspecialchars($project['id']) ?>"><?= htmlspecialchars($project['name']) ?></a>
                    <span class="main-navigation__list-item-count"><?= htmlspecialchars($project['task_count']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="add_project.php" target="project_add">Добавить
        проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>
    <form class="search-form" action="index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="?filter=all" class="tasks-switch__item <?= !isset($_GET['filter']) || $_GET['filter'] === 'all' ? 'tasks-switch__item--active' : '' ?>">Все задачи</a>
            <a href="?filter=today" class="tasks-switch__item <?= isset($_GET['filter']) && $_GET['filter'] === 'today' ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
            <a href="?filter=tomorrow" class="tasks-switch__item <?= isset($_GET['filter']) && $_GET['filter'] === 'tomorrow'? 'tasks-switch__item--active' : '' ?>">Завтра</a>
            <a href="?filter=overdue" class="tasks-switch__item <?= isset($_GET['filter']) && $_GET['filter'] === 'overdue' ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox">
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php foreach ($tasks as $task) : ?>
                <tr class="tasks__item task">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                               value="1">
                        <span class="checkbox__text"><?= htmlspecialchars($task['name'] ?? '') ?></span>
                    </label>
                </td>

                <td class="task__file">
                    <?php if (!empty($task['file'])) : ?>
                        <a class="download-link"
                           href="/uploads/<?= htmlspecialchars($task['file']) ?>"><?= htmlspecialchars($task['file']) ?></a>
                    <?php else: ?>
                        <span>Файл отсутствует</span> <!-- Удобный вывод, если файл отсутствует -->
                    <?php endif; ?>
                </td>
                <td class="task__date"><?= htmlspecialchars($task['date_term'] ?? '') ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</main>