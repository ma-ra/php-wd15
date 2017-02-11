<?php

Yii::import('application.extensions.tcpdf.*');
require_once('tcpdf/tcpdf.php');

class ZebraShippingLabel extends TCPDF {
	
	// Page header
	function Header() {
	}
	
	
	// Page footer
	function Footer() {
	}
}
?>