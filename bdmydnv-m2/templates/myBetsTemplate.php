
<section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php foreach($userLots as $lotInfo): ?>
        <?php $date = timeLeft($lotInfo['endDate'])?>
        <?php if($lotInfo['winner'] != "" && $lotInfo['betUser'] === $lotInfo['winner']): ?>
        <tr class="rates__item rates__item--win">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= htmlspecialchars($lotInfo["img"]) ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <div>
              <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($lotInfo['id']) ?>"><?= htmlspecialchars($lotInfo["nameLot"]) ?></a></h3>
              <p><?= $lotInfo['contact'] ?></p>
            </div>
          </td>
          <td class="rates__category">
            <?=htmlspecialchars($lotInfo['nameCategory'])?>
          </td>
          <td class="rates__timer">
            <div class="timer timer--win">Ставка выиграла</div>
          </td>
          <td class="rates__price">
            <?= htmlspecialchars(priceFormat($lotInfo['priceBet'])) ?>
          </td>
          <td class="rates__time">
          <?php $reverseTime = reverseTimeLeft($lotInfo['timeBet']);
            if($reverseTime[0] == 0): ?>
            <?= htmlspecialchars($reverseTime[1]) ?> <?php if($reverseTime[1] % 10 === 1 && $reverseTime[1] != 11): ?>минуту<?php elseif(($reverseTime[1] % 10 > 1 && $reverseTime[1] % 10 < 5) && intdiv($reverseTime[1], 10) !== 1): ?>минуты<?php else: ?>минут<?php endif;?> назад 
          <?php elseif($reverseTime[0] >= 1 && $reverseTime[0] < 24):?>
            <?= htmlspecialchars($reverseTime[0]) ?> <?php if($reverseTime[0] % 10 === 1 && $reverseTime[0] != 11): ?>час<?php elseif(($reverseTime[0] % 10 > 1 && $reverseTime[0] % 10 < 5) && intdiv($reverseTime[0], 10) !== 1): ?>часа<?php else: ?>часов<?php endif;?> назад
          <?php else: ?> 
            <?=htmlspecialchars($lotInfo['timeBet'])?>
          <?php endif; ?>
          </td>
        </tr>
        <?php elseif($date[0] < 0): ?>
        <tr class="rates__item rates__item--end">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= htmlspecialchars($lotInfo["image"])?>" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($lotInfo['id']) ?>"><?= htmlspecialchars($lotInfo["nameLot"])?></a></h3>
          </td>
          <td class="rates__category">
            <?=htmlspecialchars($lotInfo['nameCategory'])?>
          </td>
          <td class="rates__timer">
              <div class="timer timer--end">Торги окончены</div>
          </td>
          <td class="rates__price">
            <?= htmlspecialchars(priceFormat($lotInfo['priceBet'])) ?>
          </td>
          <td class="rates__time">
          <?php $reverseTime = reverseTimeLeft($lotInfo['timeBet']);
            if($reverseTime[0] === 1): ?>
            <?= htmlspecialchars($reverseTime[1]) ?> <?php if($reverseTime[1] % 10 === 1 && $reverseTime[1] != 11): ?>минуту<?php elseif(($reverseTime[1] % 10 > 1 && $reverseTime[1] < 5) && intdiv($reverseTime[1], 10) !== 1): ?>минуты<?php else: ?>минут<?php endif;?> назад 
          <?php elseif($reverseTime[0] > 1 && $reverseTime[0] < 24):?>
            <?= htmlspecialchars($reverseTime[0]) ?> <?php if($reverseTime[0] % 10 === 1 && $reverseTime[0] != 11): ?>час<?php elseif(($reverseTime[0] % 10 > 1 && $reverseTime[0] % 10 < 5) && intdiv($reverseTime[0], 10) !== 1): ?>часа<?php else: ?>часов<?php endif;?> назад
          <?php else: ?> 
            <?=htmlspecialchars($lotInfo['timeBet'])?>
          <?php endif; ?>
          </td>
        </tr>
        <?php else: ?>
          <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= htmlspecialchars($lotInfo["image"]) ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($lotInfo['id']) ?>"><?= htmlspecialchars($lotInfo["nameLot"]) ?></a></h3>
          </td>
          <td class="rates__category">
            <?=htmlspecialchars($lotInfo['nameCategory'])?>
          </td>
          <td class="rates__timer">
          
            <div class="lot-item__timer timer <?php if ($date[0] < "24"):?> timer--finishing <?php endif;?>">
                <?=htmlspecialchars($date[0])?>:<?=htmlspecialchars($date[1])?>
            </div>
          </td>
          <td class="rates__price">
            <?= htmlspecialchars(priceFormat($lotInfo['priceBet'])) ?>
          </td>
          <td class="rates__time">
          <?php $reverseTime = reverseTimeLeft($lotInfo['timeBet']);
          $bet_date = getdate($lotInfo['timeBet']);
          if($reverseTime[0] === 1): ?>
            <?= htmlspecialchars( $reverseTime[1]) ?> <?php if($reverseTime[1] % 10 === 1 && $reverseTime[1] != 11): ?>минуту<?php elseif(($reverseTime[1] % 10 > 1 && $reverseTime[1] % 10 < 5) && intdiv($reverseTime[1], 10) !== 1): ?>минуты<?php else: ?>минут<?php endif;?> назад 
          <?php elseif($reverseTime[0] > 1 && $reverseTime[0] < 24):?>
            <?= htmlspecialchars($reverseTime[0]) ?> <?php if($reverseTime[0] % 10 === 1 && $reverseTime[0] != 11): ?>час<?php elseif($reverseTime[0] % 10 > 1 && $reverseTime[0] % 10 < 5 && intdiv($reverseTime[0], 10) !== 1): ?>часа<?php else: ?>часов<?php endif;?> назад
          <?php elseif($reverseTime[0] > 24 && $reverseTime[0] < 48): ?>
            Вчера в <?= htmlspecialchars($reverseTime[0]) ?>:<?=htmlspecialchars( $reverseTime[1])?>
          <?php else:?>
            <?=htmlspecialchars($lotInfo['timeBet'])?>
          <?php endif; ?>
          </td>
        </tr>
        <?php endif;?>
        <?php endforeach; ?>
      </table>
    </section>