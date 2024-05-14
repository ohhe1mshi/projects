<form class="form container <?php if ($_POST != []): ?> form--invalid<?php endif; ?>" action="signUp.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if ($_POST != [] && !empty($errors['email'])): ?> form__item--invalid <?php endif; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" value="<?= getPostVal('email') ?>" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?=$errors['email'] ?? '' ?></span>
      </div>
      <div class="form__item <?php if ($_POST != [] && !empty($errors['email'])): ?> form__item--invalid <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" value="<?= getPostVal('password') ?>" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? '' ?></span>
      </div>
      <div class="form__item <?php if ($_POST != [] && !empty($errors['name'])): ?> form__item--invalid <?php endif; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" value="<?= getPostVal('name') ?>" name="name" placeholder="Введите имя">
        <span class="form__error"><?=$errors['name'] ?? '' ?></span>
      </div>
      <div class="form__item <?php if ($_POST != [] && !empty($errors['message'])): ?> form__item--invalid <?php endif; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= getPostVal('message') ?></textarea>
        <span class="form__error"><?=$errors['message'] ?? '' ?></span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>