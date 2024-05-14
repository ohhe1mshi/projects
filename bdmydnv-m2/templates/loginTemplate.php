<form class="form container <?php if ($_POST != [] && $errors != []): ?> form--invalid<?php endif; ?>" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?php if ($_POST != [] && (!empty($errors['email']) || !empty($errors['user']))): ?> form__item--invalid <?php endif; ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" value="<?= getPostVal('email') ?>" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?=$errors['email'] ?? '' ?></span>
      </div>
      <div class="form__item form__item--last <?php if ($_POST != [] && (!empty($errors['password']) || !empty($errors['user']))): ?> form__item--invalid <?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" value="<?= getPostVal('password') ?>" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password'] ?? '' ?><?=$errors["user"] ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>