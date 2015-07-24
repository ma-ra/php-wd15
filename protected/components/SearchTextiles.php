<?php

Yii::import('application.extensions.tcpdf.*');
require_once('tcpdf/tcpdf.php');

class SearchTextiles extends TCPDF {
	private $start;
	private $mytitle="Niewykorzystane wykroje";
	
	public $cellWidth=array( //A4 portriat - max width: 200
		0 => 28, //numer modelu
		1 => 43, //do użycia (numer zamówienia)
		2 => 43, //dopasowanie - obydwa
		3 => 43, //dopasowanie - pierwszy
		4 => 43, //dopasowanie - drugi
	);
	
	public function Initiate() {
		$this->SetAuthor("Firma Wyrwał Daniel");
		$this->SetCreator("WD15");
		$this->SetSubject("Dopasowanie do niewykorzystanych wykroji");
		$this->SetTitle("Wolne wykroje");
		$this->SetKeywords("WD15, wykroje, wolne, niewykorzystane");
			
		$this->SetDisplayMode("fullpage","OneColumn");
		$this->setPrintHeader(true);
		$this->setPrintFooter(true);
		$this->SetMargins(5,5,5,true);
		$this->SetAutoPageBreak(true,0);
	
		$this->SetFont("FreeSans", "", 12);
		//$this->SetFont("DejaVuSans", "", 12);
		$this->setCellMargins(0, 0, 0, 0);
		$this->setCellPaddings(1, 1, 1, 1);
		
		$this->AddPage();
	}
	
	// Page header
	function Header() {
		$this->SetFillColor(190, 190, 190);
		$this->SetFont("FreeSans", "", 10);
		$this->SetXY(5,5);
		// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(0, 0, $this->mytitle, 0, 1, "C");
		$this->Ln();
		
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$headers=array(
			'numer modelu',
			'do użycia (numer zamówienia)',
			'dopasowanie - obydwa',
			'dopasowanie - pierwszy',
			'dopasowanie - drugi',
		);
		foreach ($headers as $index => $header) {
			// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($this->cellWidth[$index], $header)) {
				$textHeight=$this->getStringHeight($this->cellWidth[$index], $header)+1; //+1 pt na minimalny odstęp
			}
		};
			
		## drukujemy
		foreach ($headers as $index => $header) {
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($this->cellWidth[$index], $textHeight, $headers[$index], 1, 'C', 0, 0, '', '', true, 1);
		}
		$this->Ln();
		$this->start=$this->GetY();
	}
	
	function Draw($row) {
		$this->SetFont("FreeSans", "", 10);
		$this->SetY($this->start);
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		foreach ($row as $index => $field) {
			// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($this->cellWidth[$index], $field)) {
				$textHeight=$this->getStringHeight($this->cellWidth[$index], $field)+1; //+1 pt na minimalny odstęp
			}
		};
			
		## drukujemy
		foreach ($row as $index => $field) {
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
			$this->MultiCell($this->cellWidth[$index], $textHeight, $field, 1, 'C', 0, 0, '', '', true, 0, false, true, $textHeight, 'M', false);
		}
		$this->Ln();
		$this->start=$this->GetY();
	}
	
	// Page footer
	function Footer() {
		$this->SetFont("FreeSans", "", 8);
		$this->SetXY(5,297-5-$this->getStringHeight(1, ""));
		// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(25, 0, date('Y-m-d'), 0, 0, "L");
		$this->Cell(150, 0, "Wydrukowane z aplikacji WD15 / Copyright © 2015 by Marek Ramotowski for Wyrwał Daniel", 0, 0, "C");
		$this->Cell(25, 0,  $this->getPage() . "/" . trim($this->getAliasNbPages()), 0, 0, "R");
	}
}
?>