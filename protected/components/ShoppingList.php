<?php

Yii::import('application.extensions.tcpdf.*');
require_once('tcpdf/tcpdf.php');

class ShoppingList extends TCPDF {
	// Page header
	function Header() {
	}
	
	// Page footer
	function Footer() {
		$this->SetFont("FreeSans", "", 12);
		$this->SetXY(5,297-10);
		// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
		$this->Cell(100, 0, date('Y-m-d H:i'), 0, 0, "L");
		$this->Cell(100, 0,  $this->getPage() . "/" . $this->getNumPages(), 0, 0, "R");
	}
}
?>