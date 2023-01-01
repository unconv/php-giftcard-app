<?php
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../db.php';

header('Content-Type: application/pdf');

GiftcardPDF::print_by_id( $db, $_GET['id'] );
