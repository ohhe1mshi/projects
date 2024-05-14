<div class="container">
      <section class="lots">
        <h2>Все лоты в категории <span>«<?= htmlspecialchars($category) ?>»</span></h2>
        <?php if(empty($lots)): ?>
            <p>Ничего не найдено по вашему запросу</p>
        <?php else: ?>
        <ul class="lots__list">
          <?php foreach ($lots as $item): ?>       
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($item['image'])?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($item['nameCategory'])?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=htmlspecialchars($item['id'])?>"><?=htmlspecialchars($item['nameLot'])?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=htmlspecialchars(priceFormat($item['price'] ?? $item['startPrice']))?></span>
                        </div>
                        <?php $date = timeLeft($item['endDate'])?>
                        <div class="lot__timer timer <?php if ($date[0] < "24"):?> timer--finishing <?php endif;?>">
                            <?=htmlspecialchars($date[0]);?>:<?=htmlspecialchars($date[1])?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach?>
        </ul>
      </section>
      <?php if($countPages > 1):?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev "><?php if(getGetVal('page') != 1): ?><a href="allLots.php?category=<?= htmlspecialchars($item['nameCategory']) ?>&page=<?=htmlspecialchars(getGetVal('page') - 1)?>">Назад</a><?php endif; ?></li>
            <?php for($i = 1; $i <= $countPages ;$i++):?>
        <li class="pagination-item <?php if($i == $_GET['page']): ?> pagination-item-active<?php endif; ?>"><a href="allLots.php?category=<?= htmlspecialchars($item['nameCategory']) ?>&page=<?=htmlspecialchars($i)?>"><?= $i ?></a></li>
        <?php endfor?>
        <li class="pagination-item pagination-item-next"><?php if(getGetVal('page') != $countPages): ?><a href="allLots.php?category=<?= htmlspecialchars($item['nameCategory']) ?>&page=<?=htmlspecialchars(getGetVal('page') + 1)?>">Вперед</a><?php endif; ?></li>    
      </ul>
      <?php endif; ?>
      <?php endif;?>
    </div>