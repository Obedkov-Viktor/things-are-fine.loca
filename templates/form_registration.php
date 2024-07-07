<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

    <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="/register.php" method="post" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?= !empty($errors) ? 'form__input--error' : '' ?>" type="text" name="email"
                   id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Введите e-mail">
            <?php if (in_array('E-mail введён некорректно', $errors)): ?>
                <p class="form__message">E-mail введён некорректно</p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>
            <input class="form__input" type="password" name="password" id="password" value=""
                   placeholder="Введите пароль">
            <?php if (in_array('Введите пароль', $errors)): ?>
                <p class="form__message">Введите пароль</p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>
            <input class="form__input" type="text" name="name" id="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" placeholder="Введите имя">
            <?php if (in_array('Введите имя', $errors)): ?>
                <p class="form__message">Введите имя</p>
            <?php endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <?php if (!empty($errors)): ?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif; ?>
            <input class="button" type="submit" value="Зарегистрироваться">
        </div>
    </form>
</main>
