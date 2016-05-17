<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');
require_once('qrcode/qrcode.class.php');

class ShippingLabel extends FPDF {
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
	
	// Page header
	function Header() {
		$this->AddFont('arial_ce','','arial_ce.php');
		$this->AddFont('arial_ce','I','arial_ce_i.php');
		$this->AddFont('arial_ce','B','arial_ce_b.php');
		$this->AddFont('arial_ce','BI','arial_ce_bi.php');
	}
	
	function Draw($c) {
		
		#Współżędne dla ćwiartek
		if ($c == 1) {
			$x=0;
			$y=0;
		} else if ($c == 2) {
			$x=143.5;
			$y=0;
		} else if ($c == 3) {
			$x=0;
			$y=100;
		} else if ($c == 4) {
			$x=143.5;
			$y=100;
		} else {
			$x=0;
			$y=0;
		}
		
		#Domyślna numeracja etykiet
		isset($this->number)? true : $this->number=1;
		isset($this->totalNumber)? true : $this->totalNumber=1;
		
		#Nagłowek
		$this->SetFont('arial_ce','B',18);
		$this->SetXY(5+$x,5+$y);
		$this->Cell(143.5, 8, $this->lieferant, 0, 2, "C");
		
		#Lewa strona
		$this->SetFont('arial_ce','',12);
		$this->Rect(5+$x, 13+$y, 143.5, 20);
		$this->GetStringWidth("Model: " . iconv('utf-8', 'windows-1250',$this->model)) > 143.5 ? $this->SetFont('arial_ce','',11): true;
		$this->GetStringWidth("Model: " . iconv('utf-8', 'windows-1250',$this->model)) > 143.5 ? $this->SetFont('arial_ce','',10): true;
		$this->Cell(143.5, 5, "Model: " . iconv('utf-8', 'windows-1250',$this->model), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$position=$this->GetX();
		$this->Cell(15, 5, "Dessin: ", 0, 0, "L");
		$this->GetStringWidth($this->dessin) > 128 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(128.5, 5, iconv('utf-8', 'windows-1250',$this->dessin), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->SetX($position);
		$this->Cell(143.5, 5, "Variant: " . iconv('utf-8', 'windows-1250',$this->variant), 0, 2, "L");
		$this->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße: " . $this->fusse), 0, 2, "L");
		$this->Cell(143.5, 5, "", 0, 2, "L");
		
		$this->Cell(143.5, 5, "Empfanger: ", 0, 2, "L");
		$this->GetStringWidth($this->empfanger) > 140 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->MultiCell(71.75, 5, iconv('utf-8', 'windows-1250',$this->empfanger), 0, "L");
		$this->SetFont('arial_ce','',12);
		
		$this->Rect(5+$x, 53+$y, 71.75, 39);
		$this->Rect(76.75+$x, 53+$y, 71.75, 39);
		$this->SetXY(5+$x,53+$y);
		$this->Cell(71.75, 5, "Auftrag - nr: " . iconv('utf-8', 'windows-1250',$this->auftragNr), 0, 2, "L");
		
		$position=$this->GetX();
		$this->Cell(30, 5, "Bestellnummer: ", 0, 0, "L");
		$this->GetStringWidth($this->bestellnummer) > 41 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(41.75, 5, iconv('utf-8', 'windows-1250',$this->bestellnummer), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->SetX($position);
		
		$this->Cell(71.75, 5, "Lieferanschrift: ", 0, 2, "L");
		$this->Cell(71.75, 5, "", 0, 2, "L");
		$this->GetStringWidth($this->lieferanschrift) > 71 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->lieferanschrift), 0, 2, "L");
		$this->GetStringWidth($this->strasse) > 71 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->strasse), 0, 2, "L");
		$this->GetStringWidth($this->plz) > 71 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->plz), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		
		#Stopka z numeracją etykiet
		//$this->Rect(5, 98, 71.75, 10);
		$this->Cell(143.5, 5, "", 0, 2, "L");
		$this->Cell(143.5, 3, "", 0, 2, "L");
		$this->SetX(71.75+5+$x-25);
		$this->Cell(50, 5, $this->number . "        von        " . $this->totalNumber, 1, 2, "C");
		
		#Prawa strona
		$this->SetXY(76.75+$x, 38+$y);
		$this->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->lieferant), 0, 2, "L");
		#TO DO: adres z bazy zamiast zakodowany
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250','Hafervöhde 7, DE-59457 Werl'), 0, 2, "L");
		
		$this->SetXY(76.75+$x, 53+$y);
		$this->Cell(71.75, 5, "Artikel - nr: " . iconv('utf-8', 'windows-1250',$this->artikelNr), 0, 2, "L");
		$this->Cell(71.75, 5, "", 0, 2, "L");
		$this->Cell(14, 5, "Model: ",0, 0, "L");
		$this->GetStringWidth($this->model) > 57 ? $this->SetFont('arial_ce','',11) : $this->SetFont('arial_ce','',12);
		$this->MultiCell(57.75, 5, iconv('utf-8', 'windows-1250',$this->model), 0, "L");
		$this->SetXY(76.75+$x, 78+$y);
		//$this->Cell(71.75, 5, "", 0, 2, "L");
		$this->GetStringWidth($this->eanNummer) > 71 ? $this->SetFont('arial_ce','',10) : $this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, "EAN Nummer: " . iconv('utf-8', 'windows-1250',$this->eanNummer), 0, 2, "L");
		
		#Barcode
		$number=$number = sprintf('%012d', $this->id);
		$this->EAN13(5+$x+2, 53+$y+40,$number,7);
		//numer tygodnia (termin) ukryty obok kodu kreskowego
		$this->SetXY(5+$x+32, 53+$y+47);
		$this->Cell(10, 5, $this->order_term, 0, 2, "L");
		
		#QRCode
		//$ Qrcode = new QRCode ("Twoja wiadomość tutaj", "H");  // Poziom błędu: L, M, P, H
		$qrcode = new QRcode($number, "L"); //The string you want to encode
		$qrcode->displayFPDF($this, 148.5+$x-25, 53+$y+27, 25); //PDF object, X pos, Y pos, Size of the QR code 
	}
	
	function  DrawLine() {
		$this->SetDash(1,1);
		$this->Line(148.5, 5, 148.5, 205);
		$this->Line(5, 105, 292, 105);
		#Cztery prostokąty zamiast powyższych linii
		//$pdf->Rect(5, 5, 143.5, 100);
		//$pdf->Rect(148.5, 5, 143.5, 100);
		//$pdf->Rect(5, 105, 143.5, 100);
		//$pdf->Rect(148.5, 105, 143.5, 100);
		$this->SetDash();
	}

	// Page footer
	function Footer() {
	}
	
	############################
	####                    ####
	####  Dashes function   ####
	####                    ####
	############################
	function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
	
	############################
	####                    ####
	####  Barcode function  ####
	####                    ####
	############################
	function EAN13($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->Barcode($x,$y,$barcode,$h,$w,13);
	}

	function UPC_A($x, $y, $barcode, $h=16, $w=.35)
	{
		$this->Barcode($x,$y,$barcode,$h,$w,12);
	}

	function GetCheckDigit($barcode)
	{
		//Compute the check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		$r=$sum%10;
		if($r>0)
			$r=10-$r;
		return $r;
	}

	function TestCheckDigit($barcode)
	{
		//Test validity of check digit
		$sum=0;
		for($i=1;$i<=11;$i+=2)
			$sum+=3*$barcode[$i];
		for($i=0;$i<=10;$i+=2)
			$sum+=$barcode[$i];
		return ($sum+$barcode[12])%10==0;
	}

	function Barcode($x, $y, $barcode, $h, $w, $len)
	{
		//Padding
		$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
		if($len==12)
			$barcode='0'.$barcode;
		//Add or control the check digit
		if(strlen($barcode)==12)
			$barcode.=$this->GetCheckDigit($barcode);
		elseif(!$this->TestCheckDigit($barcode))
			$this->Error('Incorrect check digit');
		//Convert digits to bars
		$codes=array(
			'A'=>array(
				'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
				'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
			'B'=>array(
				'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
				'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
			'C'=>array(
				'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
				'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
			);
		$parities=array(
			'0'=>array('A','A','A','A','A','A'),
			'1'=>array('A','A','B','A','B','B'),
			'2'=>array('A','A','B','B','A','B'),
			'3'=>array('A','A','B','B','B','A'),
			'4'=>array('A','B','A','A','B','B'),
			'5'=>array('A','B','B','A','A','B'),
			'6'=>array('A','B','B','B','A','A'),
			'7'=>array('A','B','A','B','A','B'),
			'8'=>array('A','B','A','B','B','A'),
			'9'=>array('A','B','B','A','B','A')
			);
		$code='101';
		$p=$parities[$barcode[0]];
		for($i=1;$i<=6;$i++)
			$code.=$codes[$p[$i-1]][$barcode[$i]];
		$code.='01010';
		for($i=7;$i<=12;$i++)
			$code.=$codes['C'][$barcode[$i]];
		$code.='101';
		//Draw bars
		for($i=0;$i<strlen($code);$i++)
		{
			if($code[$i]=='1')
				$this->Rect($x+$i*$w,$y,$w,$h,'F');
		}
		//Print text uder barcode
		$this->SetFont('Arial','',12);
		$this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
	}
}
?>