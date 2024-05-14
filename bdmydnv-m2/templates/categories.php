<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item): ?>
            <li class="nav__item  <?php if($item['nameCategory'] == getGetVal('category') ?? ""): ?>nav__item--current<?php endif; ?>">
                <a href="allLots.php?category=<?=htmlspecialchars($item['nameCategory'])?>&page=1"><?=htmlspecialchars($item['nameCategory'])?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>