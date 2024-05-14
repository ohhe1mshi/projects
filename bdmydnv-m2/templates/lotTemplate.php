
<section class="lot-item container">
  <h2><?=htmlspecialchars($lotInfo['nameLot']) ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=htmlspecialchars($lotInfo['image']) ?>" width="730" height="548" alt="<?=htmlspecialchars($lotInfo['nameLot']) ?>">
      </div>
      <p class="lot-item__category">Категория: <span><?=htmlspecialchars($lotInfo['category']) ?></span></p>
      <p class="lot-item__description"><?=htmlspecialchars($lotInfo['description']) ?></p>
    </div>
    <div class="lot-item__right">
      <div class="lot-item__state">
        <div class="lot-item__timer timer <?php if(timeLeft($lotInfo['endDate'])[0] < "01"): ?> timer--finishing<?php endif;?>">
            <?=timeLeft($lotInfo['endDate'])[0]?>:<?=timeLeft($lotInfo['endDate'])[1]?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=htmlspecialchars(priceFormat($lotInfo['price'] ?? $lotInfo['startPrice'])) ?></span>
          </div>
          <div class="lot-item__min-cost">
Мин. ставка <span><?=htmlspecialchars(priceFormat(($lotInfo['price'] ?? $lotInfo['startPrice']) + $lotInfo['priceStep'])) ?></span>
          </div>
        </div>
        <form class="lot-item__form <?php if(!isset($_SESSION["username"]) || $lotInfo['betUser'] == $_SESSION['userId'] || $lotInfo['author'] == $_SESSION['username']): ?>visually-hidden <?php endif; ?>" action="lot.php?id=<?=htmlspecialchars($lotInfo['id'])?>" method="post" autocomplete="off">
            <p class="lot-item__form-item form__item <?php if(!empty($error['cost'])): ?>form__item--invalid<?php endif; ?> ">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= htmlspecialchars(priceFormat(($lotInfo['price'] ?? $lotInfo['startPrice']) + $lotInfo['priceStep'])) ?>">
                <span class="form__error"><?=$error['cost']?></span>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
        </form>
    </div>
    <?php if(!empty($betsInfo)): ?>
    <div class="history">
        <h3>История ставок (<span><?= count($betsInfo) ?></span>)</h3>
        <table class="history__list">
            <?php foreach($betsInfo as $bet): ?>
            <tr class="history__item">
                <td class="history__name"><?= htmlspecialchars($bet['nameUser']) ?></td>
                <td class="history__price"><?= htmlspecialchars(priceFormat($bet['priceBet'])) ?></td>
                <td class="history__time"><?= htmlspecialchars($bet['timeBet']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
    </div>
  </div>
</section>
