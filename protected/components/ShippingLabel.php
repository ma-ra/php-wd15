<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');

class ShippingLabel extends FPDF {
	public $model;
	public $dessin;
	public $variant;
	public $fusse;
	public $empfanger;
	public $lieferant;
	public $auftragNr;
	public $bestellnummer;
	public $lieferanschrift;
	public $strasse;
	public $plz;
	public $artikelNr;
	public $eanNummer;
	public $number;
	public $totalNumber;
	
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
		$this->Cell(143.5, 8, "REALITY IMPORT GMBH", 0, 2, "C");
		
		#Lewa strona
		$this->SetFont('arial_ce','',12);
		$this->Rect(5+$x, 13+$y, 143.5, 20);
		$this->Cell(143.5, 5, "Model: " . iconv('utf-8', 'windows-1250',$this->model), 0, 2, "L");
		$position=$this->GetX();
		$this->Cell(15, 5, "Dessin: ", 0, 0, "L");
		strlen($this->dessin) > 63 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(128.5, 5, iconv('utf-8', 'windows-1250',$this->dessin), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->SetX($position);
		$this->Cell(143.5, 5, "Variant: " . iconv('utf-8', 'windows-1250',$this->variant), 0, 2, "L");
		$this->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße: " . $this->fusse), 0, 2, "L");
		$this->Cell(143.5, 5, "", 0, 2, "L");
		
		$this->Cell(143.5, 5, "Empfanger: ", 0, 2, "L");
		strlen($this->empfanger) > 36 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(143.5, 5, iconv('utf-8', 'windows-1250',$this->empfanger), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->Cell(143.5, 5, "", 0, 2, "L");
		
		$this->Rect(5+$x, 53+$y, 71.75, 40);
		$this->Rect(76.75+$x, 53+$y, 71.75, 40);
		$this->Cell(71.75, 5, "Auftrag - nr: " . iconv('utf-8', 'windows-1250',$this->auftragNr), 0, 2, "L");
		
		$position=$this->GetX();
		$this->Cell(30, 5, "Bestellnummer: ", 0, 0, "L");
		strlen($this->bestellnummer) > 16 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(41.75, 5, iconv('utf-8', 'windows-1250',$this->bestellnummer), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->SetX($position);
		
		$this->Cell(71.75, 5, "Lieferanschrift: ", 0, 2, "L");
		$this->Cell(71.75, 5, "", 0, 2, "L");
		strlen($this->empfanger) > 36 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->empfanger), 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->strasse), 0, 2, "L");
		$this->Cell(71.75, 5, iconv('utf-8', 'windows-1250',$this->plz), 0, 2, "L");
		
		#Stopka z numeracją etykiet
		//$this->Rect(5, 98, 71.75, 10);
		$this->Cell(143.5, 5, "", 0, 2, "L");
		$this->Cell(143.5, 5, "", 0, 2, "L");
		$this->SetX(148.5-50+$x);
		$this->Cell(50, 5, $this->number . "        von        " . $this->totalNumber, 1, 2, "C");
		
		#Prawa strona
		$this->SetXY(76.75+$x, 38+$y);
		$this->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		$this->Cell(143.5, 5, iconv('utf-8', 'windows-1250',$this->lieferant), 0, 2, "L");
		
		$this->SetXY(76.75+$x, 53+$y);
		$this->Cell(71.75, 5, "Artikel - nr: " . iconv('utf-8', 'windows-1250',$this->artikelNr), 0, 2, "L");
		$this->Cell(71.75, 5, "", 0, 2, "L");
		$this->Cell(14, 5, "Model: ",0, 0, "L");
		strlen($this->model) > 29 ? $this->SetFont('arial_ce','',11) : $this->SetFont('arial_ce','',12);
		$this->MultiCell(57.75, 5, iconv('utf-8', 'windows-1250',$this->model), 0, "L");
		$this->SetX(76.75+$x);
		$this->Cell(71.75, 5, "", 0, 2, "L");
		$this->SetFont('arial_ce','',12);
		$this->Cell(71.75, 5, "EAN Nummer: " . iconv('utf-8', 'windows-1250',$this->eanNummer), 0, 2, "L");
	}
	
	function  DrawLine() {
		$this->Line(148.5, 5, 148.5, 205);
		$this->Line(5, 105, 292, 105);
		#Cztery prostokąty zamiast powyższych linii
		//$pdf->Rect(5, 5, 143.5, 100);
		//$pdf->Rect(148.5, 5, 143.5, 100);
		//$pdf->Rect(5, 105, 143.5, 100);
		//$pdf->Rect(148.5, 105, 143.5, 100);
	}

	// Page footer
	function Footer() {
	}
}
?>