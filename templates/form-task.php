<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($userProjects as $project) : ?>
                    <li class="main-navigation__list-item">
                        <a class="main-navigation__list-item-link"
                           href="#"><?= htmlspecialchars($project['name']) ?></a>
                        <span class="main-navigation__list-item-count">0</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить
            проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form" action="add_task.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="form__row">
                <label class="form__label" for="name">Название <sup>*</sup></label>

                <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : '' ?>" type="text"
                       name="name" id="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                       placeholder="Введите название">
                <?php if (isset($errors['name'])) : ?>
                    <p class="form__message"><?= $errors['name'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
                <label class="form__label" for="project">Проект <sup>*</sup></label>
                <select class="form__input form__input--select <?= isset($errors['project']) ? 'form__input--error' : '' ?>"
                        name="project" id="project">
                    <option value="">Выберите проект</option>
                    <?php foreach ($userProjects as $project) : ?>
                        <option value="<?= $project['id'] ?>"<?= ($_POST['project'] ?? '') == $project['id'] ? ' selected' : '' ?>><?= htmlspecialchars($project['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['project'])) : ?>
                    <p class="form__message"><?= $errors['project'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
                <label class="form__label" for="date">Дата выполнения</label>
                <input class="form__input form__input--date <?= isset($errors['date']) ? 'form__input--error' : '' ?>" type="text" name="date" id="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
                <?php if (isset($errors['date'])) : ?>
                    <p class="form__message"><?= $errors['date'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
                <label class="form__label" for="file">Файл</label>
                <div class="form__input-file <?= isset($errors['file']) ? 'form__input--error' : '' ?>">
                    <input class="visually-hidden" type="file" name="file" id="file" value="">
                    <label class="button button--transparent" for="file">
                        <span>Выберите файл</span>
                    </label>
                </div>
                <?php if (isset($errors['file'])) : ?>
                    <p class="form__message"><?= $errors['file'] ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row form__row--controls">
                <input class="button" type="submit" name="" value="Добавить">
            </div>
        </form>
    </main>
</div>