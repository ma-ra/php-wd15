<?php

Yii::import('application.vendor.*');
require_once('qrcode/qrcode.class.php');

class PrintZebraShippingLabel {
	public $model;
	public $dessin;
	public $variant;
	public $fusse;
	public $empfanger;
	public $lieferant;
	public $auftragNr;
	public $id;
	public $bestellnummer;
	public $lieferanschrift;
	public $strasse;
	public $plz;
	public $artikelNr;
	public $eanNummer;
	public $number;
	public $totalNumber;
	public $order_term;
	public $left_margin;
	public $right_margin;
	public $top_margin;
	
	private $pdf;
	
	function TcpdfInitiate() {
		# parametry PDF
		$this->pdf = new ZebraShippingLabel('L', 'mm', array(150,100), true, 'UTF-8');
		$this->pdf->getAliasNbPages();
		$this->pdf->SetAuthor("Firma Wyrwał Daniel");
		$this->pdf->SetCreator("WD15");
		$this->pdf->SetSubject("ZebraLabel");
		$this->pdf->SetTitle("ZebraLabel");
		$this->pdf->SetKeywords("WD15, zebra label");
			
		$this->pdf->SetDisplayMode("fullpage","OneColumn");
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
		isset($this->left_margin) ? true : $this->left_margin=2;
		isset($this->right_margin) ? true : $this->right_margin=2;
		isset($this->top_margin) ? true : $this->top_margin=2;
		$this->pdf->SetMargins($this->left_margin,$this->top_margin,$this->right_margin,true);
		$this->pdf->SetAutoPageBreak(true,0);
	
		$this->pdf->SetFont("FreeSans", "", 11);
		$this->pdf->setCellMargins(0, 0, 0, 0);
		$this->pdf->setCellPaddings(0.5, 0.5, 0.5, 0.5);
	} // TcpdfInitiate
	
	function DrawPages() {
		$this->pdf->AddPage();
		$width=$this->pdf->getPageWidth()-$this->left_margin-$this->right_margin;
		
		$this->pdf->SetFont("FreeSans", "B", 18);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$this->pdf->MultiCell(0, 7, $this->lieferant, 0, 'C', 0, 1, '', '', true, 0, false, true, 7, 'T', true);
		
		$this->pdf->SetFont("FreeSans", "", 11);
		$this->pdf->MultiCell(0, 20, "Model: $this->model\nDessin: $this->dessin\nFüße: $this->fusse", 1, 'L', 0, 1, '', '', true, 0, false, true, 20, 'M', true);
		
		$this->pdf->MultiCell($width/2, 20, "Empfanger:\n$this->empfanger", 0, 'L', 0, 0, '', '', true, 0, false, true, 20, 'T', true);
		$this->pdf->MultiCell($width/2, 20, "Lieferant:\n$this->lieferant\nHafervöhde 7, DE-59457 Werl", 0, 'L', 0, 1, '', '', true, 0, false, true, 20, 'T', true);
		
		$this->pdf->MultiCell($width/2,35, "Auftrag - nr: $this->auftragNr\nBestellnummer: $this->bestellnummer\nLieferanschrift:\n$this->lieferanschrift\n$this->strasse, $this->plz", 1, 'L', 0, 0, '', '', true, 0, false, true, 35, 'T', true);
		$this->pdf->MultiCell($width/2, 35, "Artikel - nr: $this->artikelNr\nModel: $this->model\n\nEAN Nummer: $this->eanNummer", 1, 'L', 0, 1, '', '', true, 0, false, true, 35, 'T', true);
		
		#Barcode
		$number=$number = sprintf('%012d', $this->id);
		// define barcode style
		$style = array(
				'position' => '',
				'align' => 'C',
				'stretch' => false,
				'fitwidth' => true,
				'cellfitalign' => '',
				'border' => false,
				'hpadding' => 1,
				'vpadding' => 1,
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255),
				'text' => 	true,
				'font' => 'helvetica',
				'fontsize' => 8,
				'stretchtext' => 4
		);
		$this->pdf->write1DBarcode($number, 'EAN13', '', '', '', 15, 0.45, $style, 'T');
		
		$x=$this->pdf->GetX();
		$y=$this->pdf->GetY();
		$this->pdf->MultiCell(50, 5, $this->number . "        von        " . $this->totalNumber, 1, 'C', 0, 1, $this->pdf->getPageWidth()/2-25, $y+5, true, 0, false, true, 5, 'T', true);
		
		#QRCode
		//$ Qrcode = new QRCode ("Twoja wiadomość tutaj", "H");  // Poziom błędu: L, M, P, H
		$qrcode = new QRcode($number, "L"); //The string you want to encode
		$qrcode->displayFPDF($this->pdf, $this->pdf->getPageWidth()-$this->right_margin-25, $y-25+12, 25); //PDF object, X pos, Y pos, Size of the QR code
	} // DrawPages
	
	function PrintPages() {
		$this->pdf->Close();
		
		#Drukujemy - w sensie tworzymy plik PDF
		#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
		$this->pdf->Output("Etykiety transportowe Zebra " . date('Y-m-d') . ".pdf", "I");
	}
} // class

?>