<?php
$giftcard = Giftcard::find($db, $_POST['card_id']);
if ($giftcard) {
    if($giftcard->getBalance() < $_POST['amount']) {
        echo "Not enough balance";
        exit;
    }
    $giftcard->useGiftcard($_POST['amount']);
    echo "Giftcard used";
} else {
    echo "Card not found";
}
