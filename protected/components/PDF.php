<?php

Yii::import('application.vendor.*');
require_once('fpdf17/fpdf.php');

class PDF extends FPDF {
	
	// Page header
	function Header() {
		$this->AddFont('arial_ce','','arial_ce.php');
		$this->AddFont('arial_ce','I','arial_ce_i.php');
		$this->AddFont('arial_ce','B','arial_ce_b.php');
		$this->AddFont('arial_ce','BI','arial_ce_bi.php');
	}

	// Page footer
	function Footer() {
		$this->SetY(0);
	}
}
?>