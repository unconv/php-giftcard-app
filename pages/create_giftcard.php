<?php
$factory = new GiftcardFactory($db);
$controller = new GiftcardController($factory);
$controller->createGiftcard();