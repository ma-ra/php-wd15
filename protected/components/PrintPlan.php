<?php

class PrintPlan {
	public $orders;
	public $version;
	
	private $pdf;
	
	function TcpdfInitiate() {
		# parametry PDF
		$this->pdf = new Plan('L', 'mm', 'A4', true, 'UTF-8');
		$this->pdf->getAliasNbPages();
		$this->pdf->SetAuthor("Firma Wyrwał Daniel");
		$this->pdf->SetCreator("WD15");
		$this->pdf->SetSubject("Plan");
		$this->pdf->SetTitle("Plan");
		$this->pdf->SetKeywords("WD15, plan");
			
		$this->pdf->SetDisplayMode("fullpage","OneColumn");
		$this->pdf->setPrintHeader(true);
		$this->pdf->setPrintFooter(true);
		$this->pdf->SetMargins(5,5,5,true);
		$this->pdf->SetAutoPageBreak(true,0);
	
		$this->pdf->SetFont("FreeSans", "", 12);
		//$this->pdf->SetFont("DejaVuSans", "", 12);
		$this->pdf->setCellMargins(0, 0, 0, 0);
		$this->pdf->setCellPaddings(1, 1, 1, 1);
	}
	
	function DataInitiate() {
		# ustalenie ostatniej daty dodania zamówień
		$lastOrderDateAdded=Order::model()->find(array(
			'select'=>'order_add_date',
			'order'=>'order_add_date DESC',
			'limit'=>1
		))->order_add_date;
		$this->pdf->lastOrderDateAdded=$lastOrderDateAdded;
		
		# bieżący czas
		$this->pdf->date=date('Y-m-d H:i:s');
		
		# ustalenie tytułu
		if ($this->version == "print_plan") {
			$this->pdf->title=isset($lastOrderDateAdded)? "Plan z dnia " . $this->pdf->date . " - aktualizacja zamówień z dnia: " . $lastOrderDateAdded : "Plan z dnia " . $this->pdf->date ;
		} else {
			$this->pdf->title=isset($lastOrderDateAdded)? "Zamówienia z dnia " . $this->pdf->date . " - aktualizacja zamówień z dnia: " . $lastOrderDateAdded : "Zamówienia z dnia " . $this->pdf->date ;
		}
		
		# ustalenie szerokości, nagłówków
			if ($this->version == "with_price") {
				$this->pdf->fieldsWidth=array(
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
				
				$this->pdf->headers=array(
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
				$this->pdf->fieldsWidth=array(
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
				
				$this->pdf->headers=array(
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
			} //if
	}	
	
	function DrawPages() {
		$this->pdf->AddPage();
		
		# liczba wierszy
		$count=0;
		# suma ilości mebli
		$amountSum=0;
		# suma cen w przypadku wersji z cenami
		$totalPriceSum=0;
		
		# pętla po posortowanych zamówieniach i pobranie danych
		foreach ($this->orders as $id => $order) {
			# zbieranie danych
			$order_id=$order->order_id;
			$order_number=$order->order_number;
			$article_number=$order->articleArticle->article_number;
			$model_name=$order->articleArticle->model_name;
			$model_type=$order->articleArticle->model_type;
			$article_amount=$order->article_amount; 
			$textil_pair=isset($order->textil_pair) ? $order->textil_pair : $order->textile1Textile->textile_number ;
			$textile_name1=$order->textile1Textile->textile_name;
			$textile_name2=isset($order->textile2Textile->textile_name) ? $order->textile2Textile->textile_name : "-";
			$order_term=$order->order_term;
			$leg_type=$order->legLeg->leg_type;
			$order_price=isset($order->order_price)? $order->order_price : "-";
			$order_total_price=isset($order->order_total_price)? $order->order_total_price : "-"; 
			$order_add_date=$order->order_add_date;
			
			$this->pdf->orderDateAdded=$order_add_date;

			# liczba wierszy
			$count+=1;
			# suma ilości mebli
			$amountSum+=$article_amount;
			# suma cen w przypadku wersji z cenami
			$totalPriceSum+=$order_total_price;
			
			# ustalenie danych na potrzeby wiersza
			if ($this->version == "with_price") {
				$this->pdf->row=array(
					$order_number,
					$article_number,
					$model_name,
					$model_type,
					$order_price,		
					$article_amount,
					$order_total_price,
					$textil_pair,
					$textile_name1,
					$textile_name2,
					$order_term,
					$leg_type
				);
			} else {
				$this->pdf->row=array(
					$order_number,
					"",
					$article_number,
					$model_name,
					$model_type,
					$article_amount,
					$textil_pair,
					$textile_name1,
					$textile_name2,
					$order_term,
					$leg_type
				);
			} //if
			
			# drukujemy wiersz
			$this->pdf->DrawRow();
			
			# w przypadku druku planu zapisujemy datę druku w bazie
			/* if ($this->version == "save") {
				$Order->article_planed=$this->pdf->date;
				$Order->save();
			} */
			
		} //foreach
		
		# drukujemy podsumowanie
		if ($this->version == "with_price") {
			$this->pdf->row=array(
				$count,
				"",
				"",
				"",
				"",
				$amountSum,
				$totalPriceSum,
				"",
				"",
				"",
				"",
				""
			);
		} else {
			$this->pdf->row=array(
				$count,
				"",
				"",
				"",
				"",
				$amountSum,
				"",
				"",
				"",
				"",
				""
			);
		}
		$this->pdf->DrawSummary();
		
		#Drukujemy - w sensie tworzymy plik PDF
		#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
		$this->pdf->Output("Plan" . date('Y-m-d') . ".pdf", "I");
	} // DrawPages
} // class

?>