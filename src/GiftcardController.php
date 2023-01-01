<?php
class GiftcardController {
    private $factory;

    public function __construct(GiftcardFactory $factory) {
        $this->factory = $factory;
    }

    public function createGiftcard() {
        $amount = $_POST['amount'];
        $giftcard = $this->factory->create($amount);
        echo "Gift card created with ID: " . $giftcard->getId();
    }
}
