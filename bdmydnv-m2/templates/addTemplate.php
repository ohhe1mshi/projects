<?php
require_once('init.php');
?>
    
    <?php print($categoriesContent ?? '');?>
     <form class="form form--add-lot container <?php if($errors != []): ?> form--invalid <?php endif;?>" action="add.php" method="post" enctype="multipart/form-data"> <!--form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?php if(!empty($_POST)  && !empty($errors['lot-name'])): ?> form__item--invalid <?php endif; ?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" value="<?=getPostVal('lot-name'); ?>" placeholder="Введите наименование лота">
          <span class="form__error"><?= $errors['lot-name'] ?? "" ?></span>
        </div>
        <div class="form__item <?php if(!empty($_POST)  && getPostVal('category') === ""): ?> form__item--invalid <?php endif; ?>" >
          <label for="category">Категория <sup>*</sup></label>

          <select id="category" name="category">
              <option value = "" selected hidden>Выберите категорию</option>
              <?php foreach ($categories as $item): ?>
                <option name = "option-category" <?php if (getPostVal('category') === $item['nameCategory']): ?> selected <?php endif;?> > <?=htmlspecialchars($item['nameCategory'])?></option>
              <?php endforeach;?>
          </select>

          <span class="form__error"><?= $errors['category'] ?? "" ?></span>
        </div>
      </div>
      <div class="form__item form__item--wide <?php if(!empty($_POST)  && !empty($errors['message'])): ?> form__item--invalid <?php endif; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=getPostVal('message'); ?></textarea>
        <span class="form__error"><?= $errors['message'] ?? "" ?></span>
      </div>
      <div class="form__item form__item--file <?php if(!empty($_POST)  && !empty($errors['lot-img'])): ?> form__item--invalid <?php endif; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" name="lot-img" type="file" id="lot-img" value="">
          <label for="lot-img">
Добавить
          </label>
          <span class="form__error"><?= $errors['lot-img'] ?? "" ?></span>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?php if(!empty($_POST)  && !empty($errors['lot-rate'])): ?> form__item--invalid <?php endif; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" value="<?=getPostVal('lot-rate'); ?>" type="text" name="lot-rate" placeholder="0">
          <span class="form__error"><?= $errors['lot-rate'] ?? "" ?></span>
        </div>
        <div class="form__item form__item--small <?php if(!empty($_POST) && !empty($errors['lot-step'])): ?> form__item--invalid <?php endif; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step"  value="<?=getPostVal('lot-step'); ?>" placeholder="0">
          <span class="form__error"><?= $errors['lot-step'] ?? "" ?></span>
        </div>
        <div class="form__item <?php if(!empty($_POST) && !empty($errors['lot-date'])): ?> form__item--invalid <?php endif; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date flatpickr-input" value="<?=getPostVal('lot-date'); ?>" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          <span class="form__error"><?= $errors['lot-date'] ?? "" ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>





