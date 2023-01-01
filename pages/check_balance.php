<?php
if(isset($_POST['card_number'])) {
    $giftcard = Giftcard::findByCardNumber($db, $_POST['card_number']);
    if ($giftcard) {
        echo "The balance is:".$giftcard->getBalance();

        // create "use giftcard" form
        ?>
        <h2>Use gift card</h2>
        <form action="/index.php?page=use_giftcard" method="post">
            <input type="hidden" name="card_id" value="<?php echo $giftcard->getId() ?>">
            <input type="text" name="amount" value="<?php echo $giftcard->getBalance(); ?>" placeholder="Amount">
            <input type="submit" value="Use Giftcard">
        </form>
        <?php
    } else {
        echo "Card not found";
    }
}

// form for checking balance
?>
<h2>Check gift card balance</h2>
<form action="/index.php?page=check_balance" method="post">
    <input type="text" name="card_number" placeholder="Card Number">
    <input type="submit" value="Check Balance">
</form>
