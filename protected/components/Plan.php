<?php

Yii::import('application.extensions.tcpdf.*');
require_once('tcpdf/tcpdf.php');

class Plan extends TCPDF {
	
	public $date;
	public $orderDateAdded;
	public $lastOrderDateAdded;
	public $title;
	public $fieldsWidth=array();
	public $headers=array();
	public $row=array();
	
	private $start;
	
	// Page header
	function Header() {
		$this->SetFillColor(190, 190, 190);
		$this->SetFont("FreeSans", "", 8);
		$this->SetXY(5,5);
		// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(0, 0, $this->title, 0, 1, "C");
		$this->Ln();
		
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$w=$this->fieldsWidth;
		foreach ($this->headers as $index => $header) {
			// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($w[$index], $header)) {
				$textHeight=$this->getStringHeight($w[$index], $header)+1;
			}
		};
			
		## drukujemy
		foreach ($this->headers as $index => $header) {
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($w[$index], $textHeight, $this->headers[$index], 1, 'C', 0, 0, '', '', true, 1);
		}
		$this->Ln();
		$this->start=$this->GetY();
	}
	
	// Draw row
	function DrawRow($strikethrough=0) {
		$this->SetFillColor(180, 180, 180);
		$this->SetFont("FreeSans", "", 8);
		$this->SetY($this->start);
		
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$w=$this->fieldsWidth;
		foreach ($this->row as $index => $field) {
			// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($w[$index], $field)) {
				$textHeight=$this->getStringHeight($w[$index], $field);
			}
		};
				
		## drukujemy
		foreach ($this->row as $index => $field) {
			$fill=0;
			if ($this->orderDateAdded == $this->lastOrderDateAdded && $index == 0) {
				$fill=1;
			} 
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($w[$index], $textHeight, $this->row[$index], 1, 'C', $fill, 0, '', '', true, 1);
		}
		$y=$this->GetY();
		$this->Ln();
		# drukujemy przekreślenie jak potrzeba
		if ($strikethrough==1) {
			$this->Line(5, ($y+$this->GetY())/2, 292, ($y+$this->GetY())/2);
		}
		$this->start=$this->GetY();
		
		# kolejna strona
		if ($this->GetY()>=210-10-5) {
			$this->AddPage();
		}
	}
	
	// Draw summary
	function DrawSummary() {
		$this->SetFillColor(190, 190, 190);
		$this->SetFont("FreeSans", "", 8);
		$this->SetY($this->start);
	
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$w=$this->fieldsWidth;
		foreach ($this->row as $index => $field) {
		// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($w[$index], $field)) {
				$textHeight=$this->getStringHeight($w[$index], $field);
			}
		};
	
		## drukujemy
		foreach ($this->row as $index => $field) {
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($w[$index], $textHeight, $this->row[$index], 1, 'C', 0, 0, '', '', true, 1);
		}
		$this->Ln();
		$this->start=$this->GetY();
	
		# kolejna strona
		if ($this->GetY()>=210-10-5) {
			$this->AddPage();
		}
	}
	
	// Page footer
	function Footer() {
		$this->SetFont("FreeSans", "", 8);
		$this->SetXY(5,210-5-$this->getStringHeight(1, ""));
		// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(63.5, 0, $this->date, 0, 0, "L");
		$this->Cell(160, 0, "Wydrukowane z aplikacji WD15 / Copyright © 2015 by Marek Ramotowski for Wyrwał Daniel", 0, 0, "C");
		$this->Cell(63.5, 0,  $this->getPage() . "/" . trim($this->getAliasNbPages()), 0, 0, "R");
	}
}
?>