<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');

class LoadingList extends FPDF {
	public $orderNumber;
	public $modelName;
	public $modelType;
	public $textileNumber;
	public $buyerZipCode;
	public $articleAmount;
	public $articleColi;
	
	// Page header
	function Header() {
		$this->AddFont('arial_ce','','arial_ce.php');
		$this->AddFont('arial_ce','I','arial_ce_i.php');
		$this->AddFont('arial_ce','B','arial_ce_b.php');
		$this->AddFont('arial_ce','BI','arial_ce_bi.php');
	}
	
	function Draw() {
		
		#Nagłowek
		$this->SetFont('arial_ce','',26);
		$this->SetXY(15,10);
		$this->Cell(0, 8, "Verladeliste Tour: 4/2015", 0, 2, "C");
		$this->Cell(0, 8, "", 0, 2, "C");
		$this->SetFont('arial_ce','',16);
		$this->Cell(35, 8, "Ladedatum: ", 0, 0, "L");
		$this->SetFont('arial_ce','B',16);
		$this->Cell(40, 8, "13.03.2015", "B", 1, "C");
		$this->SetFont('arial_ce','',16);
		$this->SetX(15);
		$this->Cell(35, 8, "Produzent: ", 0, 0, "L	");
		$this->SetFont('arial_ce','B',16);
		$this->Cell(40, 8, iconv('utf-8', 'windows-1250',"Daniel Wyrwał"), "B", 2, "C");
		$this->SetFont('arial_ce','',16);
		$this->Cell(0, 8, "", 0, 1, "L");
		
		#Tabela
		$this->setX(10);
		#Nagłówek
		$this->SetFont('arial_ce','B',12);
		$this->SetFillColor(220, 220, 220);
		$this->Cell(11, 8, "Pos.", 1, 0, "C", true);
		$this->Cell(20, 8, "Auftrag", 1, 0, "C", true);
		$this->Cell(20, 8, "Modell", 1, 0, "C", true);
		$this->Cell(52, 8, iconv('utf-8', 'windows-1250',"Ausführung"), 1, 0, "C", true);
		$this->Cell(23, 8, "Stoff", 1, 0, "C", true);
		$this->Cell(23, 8, "PLZ", 1, 0, "C", true);
		$this->Cell(14, 8, "Kubik", 1, 0, "C", true);
		$this->Cell(16, 8, "Anzahl", 1, 0, "C", true);
		$this->Cell(11, 8, "Colli", 1, 1, "C", true);
		
		for ($i = 1; $i < 80; $i++) {
			#Wiersz
			$this->SetFont('arial_ce','',12);
			
			$currentY=$this->GetY();
			if (297 - 22 - $currentY < 26) {
				$this->AddPage();
			}
	
			#Najpierw MultiCell
			$this->SetX(61);
			$x1=$this->GetX();
			$y1=$this->GetY();
			$text=iconv('utf-8', 'windows-1250',"3QALFU/RFU-OttomaneRFU");
			strlen($text) >20 ? $this->SetFont('arial_ce','',10) : $this->SetFont('arial_ce','',12);
			$this->MultiCell(52, 6, $text, 1, "L");
			$this->SetFont('arial_ce','',12);
			$x2=$this->GetX();
			$y2=$this->GetY();
	
			#Na lewo od MultiCell
			$this->SetXY(10,$y1);
			$this->Cell(11, $y2-$y1, $i . ".", 1, 0, "C");
			$this->Cell(20, $y2-$y1, "302920-1", 1, 0, "C");
			$this->Cell(20, $y2-$y1, "Acapulco", 1, 0, "C");
			
			#Na prawo od MultiCell
			$this->SetXY($x1+52,$y1);
			$this->Cell(23, $y2-$y1, "4041/2006", 1, 0, "C");
			$this->Cell(23, $y2-$y1, "DE 67435", 1, 0, "C");
			$this->Cell(14, $y2-$y1, " ", 1, 0, "C");
			$this->Cell(16, $y2-$y1, "12", 1, 0, "C");
			$this->Cell(11, $y2-$y1, "24", 1, 1, "C");
		}
		#Podsumowanie tabeli
		$y1=$this->GetY();
		$this->SetX($x1+52+23);
		$this->SetFont('arial_ce','',12);
		$this->Cell(23, 5, "Summe:", 1, 0, "C", true);
		$this->Cell(14, 5, "27", 1, 0, "C", true);
		$this->Cell(16, 5, "27", 1, 0, "C", true);
		$this->Cell(11, 5, "27", 1, 1, "C", true);
		
		#Podpisy
		$this->Cell(0, 16, "", 0, 1, "L");
		$this->Cell(28, 5, "", 0, 0, "L");
		$this->Cell(48, 5, "Unterschrift Produzent", "T", 0, "C");
		$this->Cell(38, 5, "", 0, 0, "L");
		$this->Cell(48, 5, "Unterschrift Fahrer", "T", 0, "C");
		$this->Cell(28, 5, "", 0, 1, "L");
		$y2=$this->GetY();
		//$y2-$y1=26
		//$this->Cell(28, 5, $y2-$y1, 1, 1, "L");
	}

	// Page footer
	function Footer() {
		$this->SetFont('arial_ce','',10);
		$this->SetXY(10,297-15);
		$this->Cell(95, 5, date('Y-m-d H:i'), 0, 0, "L");
		$this->Cell(95, 5, 'Seite: '.$this->PageNo(). '/{nb}', 0, 0, "R");
	}
}
?>