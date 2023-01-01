<?php
// Use classes from php-barcode-generator library
use Picqer\Barcode\BarcodeGeneratorPNG;

class GiftcardPDF extends FPDF {
    private $giftcard;

    public function __construct($giftcard) {
        $this->giftcard = $giftcard;
        parent::__construct('L', 'mm', array(53.98, 85.60));
        $this->SetMargins(5, 5, 5);
        $this->SetAutoPageBreak(false);
    }

    public function create() {
        $this->addPage();

        $this->setFont('Arial', 'B', 16);
        $this->cell(0, 10, 'Gift Card', 0, 1, 'C');

        $this->addBarcode();

        $this->setFont('Arial', '', 12);
        $this->cell(0, 10, 'Code: '.$this->giftcard->getCardNumber(), 0, 1, 'C');

        $this->setFont('Arial', 'B', 15);
        $this->cell(0, 10, 'Amount: $'.$this->giftcard->getBalance(), 0, 1, 'C');
    }

    public function addBarcode() {
        // Generate barcode image
        $generator = new BarcodeGeneratorPNG();
        $barcodeImageData = $generator->getBarcode(
            $this->giftcard->getCardNumber(),
            $generator::TYPE_CODE_128
        );

        // Save barcode image data to temporary file
        $barcodeImageFile = tempnam(sys_get_temp_dir(), 'barcode');
        file_put_contents($barcodeImageFile, $barcodeImageData);

        // Add barcode image to PDF
        $this->Image($barcodeImageFile, 8, 16, 70, 10, 'PNG');

        // Delete temporary file
        unlink($barcodeImageFile);

        $this->Ln(12);
    }

    public function print() {
        $this->create();
        $this->output();
    }

    public static function print_by_id($db, $id) {
        $giftcard = Giftcard::find($db, $id);
        $pdf = new GiftcardPDF( $giftcard );
        $pdf->print();
    }
}
