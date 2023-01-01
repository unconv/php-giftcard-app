<?php
class GiftcardFactory {
    public function __construct( $db ) {
        $this->db = $db;
    }

    public function generateCardNumber() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cardNumber = '';
        for ($i = 0; $i < 10; $i++) {
            $cardNumber .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $cardNumber;
    }

    public function create( $amount ) {
        $cardNumber = $this->generateCardNumber();
        $balance = $amount;
        $createdAt = date('Y-m-d H:i:s');

        $giftcard = new Giftcard( $this->db, null, $cardNumber, $balance, $createdAt);

        $giftcard->save();

        return $giftcard;
    }
}
