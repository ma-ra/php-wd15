<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');
require_once('qrcode/qrcode.class.php');

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
	public $qrcode;
	
	// Page header
	function Header() {
		$this->AddFont('arial_ce','','arial_ce.php');
		$this->AddFont('arial_ce','I','arial_ce_i.php');
		$this->AddFont('arial_ce','B','arial_ce_b.php');
		$this->AddFont('arial_ce','BI','arial_ce_bi.php');
	}
	
	
	function DrawLine() {
		# Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
	    # 0: to the right
	    # 1: to the beginning of the next line
	    # 2: below
		
		$this->SetFont('arial_ce','',11);
		
		# first column
		$this->GetStringWidth($this->orderNumber) > 18 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->orderNumber) > 18 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(18, 25, $this->orderNumber, 1, 0, "R");
		
		# second column - three line
		$x=$this->GetX(); $y=$this->GetY();
		
		$this->GetStringWidth($this->articleNumber) > 22 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleNumber) > 22 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(22, 9, $this->articleNumber, "RTL", 2, "L");
		$this->SetFont('arial_ce','',11);

		$this->GetStringWidth($this->articleName) > 22 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleName) > 22 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(22, 8, $this->articleName, "RL", 2, "L");
		$this->SetFont('arial_ce','',11);
		
		$this->GetStringWidth($this->articleType) > 112 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->articleType) > 112 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(22, 8, $this->articleType, "LB", 2, "L");
		$this->SetFont('arial_ce','',11);
		
		# third and fourth column - three line
		$this->SetXY($x+22,$y);
		$x=$this->GetX(); $y=$this->GetY();
		
		# first number and name cells
		$this->Cell(17, 9, $this->textileNumber1, "RTL", 0, "C");
		$this->GetStringWidth($this->textileName1) > 73 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->textileName1) > 73 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(73, 9, $this->textileName1, "RTL", 0, "L");
		$this->SetFont('arial_ce','',11);

		# senond number and name cells
		$this->SetXY($x, $y+9);
		$this->Cell(17, 8, $this->textileNumber2, "RL", 0, "C");
		$this->GetStringWidth($this->textileName2) > 73 ? $this->SetFont('arial_ce','',10): $this->SetFont('arial_ce','',11);
		$this->GetStringWidth($this->textileName2) > 73 ? $this->SetFont('arial_ce','',8): $this->SetFont('arial_ce','',11);
		$this->Cell(73, 8, $this->textileName2, "RL", 0, "L");
		$this->SetFont('arial_ce','',11);
		
		# empty two cells
		$this->SetXY($x, $y+17);
		$this->Cell(17, 8, "", "BT", 0, "L");
		$this->Cell(73, 8, "", "BT", 0, "L");
		
		# fifth column
		$this->SetXY($x+90, $y);
		$x=$this->GetX(); $y=$this->GetY();
		
		$this->SetFont('arial_ce','',7);
		$this->Cell(25, 3, "notki:", "RTL", 2, "L");
		$this->Cell(25, 22, "", "RBL", 2, "L");
		$this->SetFont('arial_ce','',11);
		
		# sixth column
		$this->SetXY($x+25, $y);
		$this->Cell(20, 25, $this->orderDate, 1, 0, "L");
		
		# seventh column
		$x=$this->GetX(); $y=$this->GetY();
		$this->Cell(25, 25, "", 1, 1, "L");
		
		# QRCode
		# $Qrcode = new QRCode ("Twoja wiadomość tutaj", "H");  // Poziom błędu: L, M, P, H
		$qrcode = new QRcode($this->qrcode, "L"); //The string you want to encode
		$qrcode->disableBorder();
		$qrcode->displayFPDF($this, $x+1.5, $y+1.5, 22); //PDF object, X pos, Y pos, Size of the QR code 
	}

	// Page footer
	function Footer() {
	}
}
?>