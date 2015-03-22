<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');

class MiniLabel extends FPDF {
	public $orderNumber;
	public $articleNumber;
	public $articleName;
	public $articleType;
	public $textileNumber1;
	public $textileName1;
	public $textileNumber2;
	public $textileName2;
	public $orderDate;
	
	// Page header
	function Header() {
		$this->AddFont('arial_ce','','arial_ce.php');
		$this->AddFont('arial_ce','I','arial_ce_i.php');
		$this->AddFont('arial_ce','B','arial_ce_b.php');
		$this->AddFont('arial_ce','BI','arial_ce_bi.php');
	}
	
	
	function DrawLine() {
		$this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->orderNumber) > 18 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->orderNumber) > 18 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(18, 24, $this->orderNumber, 1, 0, "R");
		
		$this->GetStringWidth($this->articleNumber) > 17 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleNumber) > 17 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(17, 24, $this->articleNumber, 1, 0, "C");
		
		$x=$this->GetX(); $y=$this->GetY();
		$this->GetStringWidth($this->articleName) > 45 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleName) > 45 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(45, 12, $this->articleName, "RTL", 2, "L");
		
		$this->GetStringWidth($this->articleType) > 45 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleType) > 45 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(45, 12, $this->articleType, "RBL", 1, "L");
		$this->SetFont('arial_ce','',11);
		
		$this->SetXY($x+45,$y);
		$x=$this->GetX(); $y=$this->GetY();
		$this->Cell(20, 12, $this->textileNumber1, "RTL", 0, "L");
		
		$this->GetStringWidth($this->textileName1) > 70 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->textileName1) > 70 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(70, 12, $this->textileName1, "RTL", 0, "L");
		$this->SetFont('arial_ce','',11);

		$this->SetXY($x, $y+12);
		$this->Cell(20, 12, $this->textileNumber2, "RBL", 0, "L");
		$this->GetStringWidth($this->textileName2) > 70 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->textileName2) > 70 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(70, 12, $this->textileName2, "RBL", 0, "L");
		$this->SetFont('arial_ce','',11);
		
		$this->SetXY($x+90, $y);
		$this->Cell(20, 24, $this->orderDate, 1, 1, "L");
	}

	// Page footer
	function Footer() {
	}
	
}
?>