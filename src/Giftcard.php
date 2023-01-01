<?php
class Giftcard {
    private $db;
    private $id;
    private $cardNumber;
    private $balance;
    private $createdAt;

    public function __construct($db, $id, $cardNumber, $balance, $createdAt) {
        $this->db = $db;
        $this->id = $id;
        $this->cardNumber = $cardNumber;
        $this->balance = $balance;
        $this->createdAt = $createdAt;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCardNumber() {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function save() {
        if ($this->id) {
            $stmt = $this->db->prepare("UPDATE gift_cards SET card_number = ?, balance = ?, created_at = ? WHERE id = ?");
            $stmt->bind_param('sdsi', $this->cardNumber, $this->balance, $this->createdAt, $this->id);
        } else {
            $stmt = $this->db->prepare("INSERT INTO gift_cards (card_number, balance, created_at) VALUES (?, ?, ?)");
            $stmt->bind_param('sds', $this->cardNumber, $this->balance, $this->createdAt);
        }

        $stmt->execute();

        if (!$this->id) {
            $this->id = $stmt->insert_id;
        }

        $stmt->close();
    }

    public static function findByColumn($db, $column, $value) {
        $stmt = $db->prepare("SELECT * FROM gift_cards WHERE $column = ?");
        $stmt->bind_param('s', $value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $giftcard = new Giftcard(
                $db,
                $row['id'],
                $row['card_number'],
                $row['balance'],
                $row['created_at']
            );
            $result->close();
            $stmt->close();
            return $giftcard;
        } else {
            $result->close();
            $stmt->close();
            return null;
        }
    }

    public static function find($db, $id) {
        return self::findByColumn($db, 'id', $id);
    }

    public static function findByCardNumber($db, $cardNumber) {
        return self::findByColumn($db, 'card_number', $cardNumber);
    }

    public function useGiftcard($amount) {
        $this->balance -= $amount;
        $this->save($this->db);
    }
}
