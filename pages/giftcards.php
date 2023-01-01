<?php
$result = $db->query("SELECT * FROM gift_cards");
?>

<h2>Gift cards</h2>
<table>
    <tr>
        <th>Card Number</th>
        <th>Balance</th>
        <th>Created At</th>
        <th>Print PDF</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['card_number'] ?></td>
            <td><?php echo $row['balance'] ?></td>
            <td><?php echo $row['created_at'] ?></td>
            <td>
                <a href="/giftcard_pdf.php?id=<?php echo $row['id'] ?>" target="_blank">
                    Print PDF
                </a>
            </td>
        </tr>
    <?php endwhile ?>
</table>

<?php
$result->close();
$db->close();
