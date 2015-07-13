<?php

Yii::import('application.extensions.tcpdf.*');
require_once('tcpdf/tcpdf.php');

class Plan extends TCPDF {
	public $order_number;
	public $article_number;
	public $model_name;
	public $model_type;
	public $article_amount;
	public $textil_pair;
	public $textile_name1;
	public $textile_name2;
	public $order_term;
	public $leg_type;
	public $order_price;
	public $order_total_price;
	public $order_add_date;
	public $pattern_order_add_date;
	
	public $title;
	
	public $start;
	public $version;
	private $fields_width=array(
		0 => 20,
		1 => 15,
		2 => 15,
		3 => 60,
		4 => 12,
		5 => 15,
		6 => 55,
		7 => 55,
		8 => 15,
		9 => 25,
	);
	
	private $headers=array(
		'zam. nr',
		'art. nr',
		'model',
		'wersja',
		'szt.',
		'mat. nr',
		'deseń 1',
		'deseń 2',
		'termin (kw)',
		'nogi'
	);
	
	//wersja planu
	function SetVersion() {
		if ($this->version == "plan3") {
			$this->fields_width=array(
				0 => 20,
				1 => 15,
				2 => 15,
				3 => 50,
				4 => 14,	
				5 => 10,
				6 => 14,	
				7 => 13,
				8 => 48,
				9 => 48,
				10 => 15,
				11 => 25,
			);
			
			$this->headers=array(
				'zam. nr',
				'art. nr',
				'model',
				'wersja',
				'cena',
				'szt.',
				'cena całości',
				'mat. nr',
				'deseń 1',
				'deseń 2',
				'termin (kw)',
				'nogi'
			);
		} else {
			$this->fields_width=array(
				0 => 20,
				1 => 20,
				2 => 15,
				3 => 15,
				4 => 50,
				5 => 12,
				6 => 15,
				7 => 50,
				8 => 50,
				9 => 15,
				10 => 25,
			);
			
			$this->headers=array(
				'zam. nr',
				'notki',
				'art. nr',
				'model',
				'wersja',
				'szt.',
				'mat. nr',
				'deseń 1',
				'deseń 2',
				'termin (kw)',
				'nogi'
			);
		}
	}
	
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
		$w=$this->fields_width;
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
	function DrawRow() {
		$this->SetFillColor(180, 180, 180);
		$this->SetFont("FreeSans", "", 8);
		$this->SetY($this->start);
		
		if ($this->version == "plan3") {
			$row=array(
				$this->order_number,
				$this->article_number,
				$this->model_name,
				$this->model_type,
				$this->order_price,		
				$this->article_amount,
				$this->order_total_price,
				$this->textil_pair,
				$this->textile_name1,
				$this->textile_name2,
				$this->order_term,
				$this->leg_type
			);
		} else {
			$row=array(
				$this->order_number,
				"",
				$this->article_number,
				$this->model_name,
				$this->model_type,
				$this->article_amount,
				$this->textil_pair,
				$this->textile_name1,
				$this->textile_name2,
				$this->order_term,
				$this->leg_type
			);
		}
		
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$w=$this->fields_width;
		foreach ($row as $index => $field) {
			// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($w[$index], $field)) {
				$textHeight=$this->getStringHeight($w[$index], $field);
			}
		};
				
		## drukujemy
		$fill=0;
		foreach ($row as $index => $field) {
			if ($this->order_add_date == $this->pattern_order_add_date && $index == 0) {
				$fill=1;
			} else {
				$fill=0;
			}
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($w[$index], $textHeight, $row[$index], 1, 'C', $fill, 0, '', '', true, 1);
		}
		$this->Ln();
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
		if ($this->version == "plan3") {
			$row=array(
				$this->article_number,
				"",
				"",
				"",
				"",
				$this->article_amount,
				$this->order_total_price,
				"",
				"",
				"",
				"",
				""
			);
		} else {
			$row=array(
				$this->article_number,
				"",
				"",
				"",
				"",
				$this->article_amount,
				"",
				"",
				"",
				"",
				""
			);
		}
	
		## ustalamy najwyższy "MultiCell"
		$textHeight=0;
		$lines=0;
		$w=$this->fields_width;
		foreach ($row as $index => $field) {
		// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
			if ($textHeight < $this->getStringHeight($w[$index], $field)) {
			$textHeight=$this->getStringHeight($w[$index], $field);
			}
		};
	
		## drukujemy
		foreach ($row as $index => $field) {
			// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
			$this->MultiCell($w[$index], $textHeight, $row[$index], 1, 'C', 0, 0, '', '', true, 1);
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
		$this->Cell(63.5, 0, date('Y-m-d H:i '), 0, 0, "L");
		$this->Cell(160, 0, "Wydrukowane z aplikacji WD15 / Copyright © 2015 by Marek Ramotowski for Wyrwał Daniel", 0, 0, "C");
		$this->Cell(63.5, 0,  $this->getPage() . "/" . trim($this->getAliasNbPages()), 0, 0, "R");
	}
}
?>