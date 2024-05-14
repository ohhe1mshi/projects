<?php

require_once('init.php');
require_once('functions.php');
require_once('helpers.php');

$expireLots = findExpireLots($con);

foreach($expireLots as $expireLot) {
    setWinner($con, $expireLot['id']);
}
