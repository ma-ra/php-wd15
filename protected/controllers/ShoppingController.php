<?php

class ShoppingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'admin'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'delete', 'print', 'html'),
				'users'=>array('mara', 'asia'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		# http://www.yiiframework.com/wiki/362/how-to-use-multiple-instances-of-the-same-model-in-the-same-form/
		$models=array();
		
		if(isset($_POST['Shopping']))
		{
			# na początek ustalamy max numer zamówienia materiałów (zakupów)
			# TO DO - przy niepoprawnej walidacji mamy dużo czasu do zapisu, co może sprzyjać dublą
			$maxShoppingNumber = Shopping::model()->find(array(
				'order'=>'shopping_number DESC',
				'limit'=>1
			));
			if (isset($maxShoppingNumber)) {
				$maxShoppingNumber=$maxShoppingNumber->shopping_number;
			} else {
				$maxShoppingNumber=0;
			}
			$shoppingNumber=array();
			
			# pętla po otrzymanych wierszach, tworzenie modelu do każdego wiersza i przypisanie atrybutów
			foreach ($_POST['Shopping'] as $key => $model) {
				$models[$key]=new Shopping;
				$check[$key]=true;
				$models[$key]->attributes=$_POST['Shopping'][$key];
				# nie wiem dalczego, ale trzeba ręcznie przepisać
				$models[$key]->order1_ids=$_POST['Shopping'][$key]['order1_ids'];
				$models[$key]->order2_ids=$_POST['Shopping'][$key]['order2_ids'];
				
				#nadajemy numer
				$supplierId=isset(Textile::model()->findByPk($models[$key]->textile_textile_id)->supplierSupplier->supplier_id) ? Textile::model()->findByPk($models[$key]->textile_textile_id)->supplierSupplier->supplier_id : "-" ;
				if (!isset($shoppingNumber[$supplierId])) {
					$maxShoppingNumber+=1;
					$shoppingNumber[$supplierId]=$maxShoppingNumber;
				} 
				
				#jeżeli podano 0, to znaczy, że nie zamawiamy
				if ($models[$key]->article_amount != null and $models[$key]->article_amount == 0) {
					$models[$key]->unsetAttributes();
				}
				
				#jeżeli nie zadeklarowano ilości oraz wyliczona ilość wynosi 0, to nie zamawiaj
				if ($models[$key]->article_amount == null and $models[$key]->article_calculated_amount == 0) {
					$models[$key]->unsetAttributes();
				}
				
				#jeżeli nie podano article amount, to z wyliczonej wartości
				if (empty($models[$key]->article_amount)) {
					$models[$key]->article_amount=$models[$key]->article_calculated_amount;
				}
				
				#taki przytrzymywacz
				//$models[$key]->article_calculated_amount=null;
				
				# nadajemy status
				$models[$key]->shopping_status="nowy";
				
				# nie weryfikuj oraz nie usówaj całkowicie pustych wierszy
				$attributes_count=0;
				foreach ($models[$key] as $attr_key => $attribute) {
					if (!empty($attribute)) {
						$attributes_count+=1;
					}
				}
				if ($attributes_count > 0) {
					$models[$key]->shopping_number=$shoppingNumber[$supplierId];
					# group by zagregował id (concat), teraz je zamieniamy na tablicę
					$order1_ids=explode(",",$models[$key]->order1_ids);
					$order2_ids=explode(",",$models[$key]->order2_ids);
						
					if($models[$key]->save()) {
						# wiązemy zakupy (shopping) z zamówieniam (order)
						foreach ($order1_ids as $order_id) {
							if (!empty($order_id)) {
								$Order=Order::model()->findByPk($order_id);
								$Order->shopping1_shopping_id=$models[$key]->shopping_id;
								$Order->save();
							}
						}
						foreach ($order2_ids as $order_id) {
							if (!empty($order_id)) {
								$Order=Order::model()->findByPk($order_id);
								$Order->shopping2_shopping_id=$models[$key]->shopping_id;
								$Order->save();
							}
						}
						# po poprawnym zapisie wyczyść prezentowany wiersz lub usuń 
						# wyczyść
						//$models[$key]->unsetAttributes();
						# usuń
						unset($check[$key]);
					}
				} else {
					# usówamy puste wiersze
					unset($check[$key]);
				}
			}
		} else {
			# jak nie otrzymaliśmy wierszy, to sami je generujemy
			for ($i = 1; $i <= 15; $i++) {
				$models[$i]=new Shopping;
			}
		}

		#jeżeli $models jest puste, to znaczy, że wszystko udało sie zapisać
		if (empty($check)) {
			$this->redirect(array('Shopping/admin'));
		}
		$this->render('create',array(
			'models'=>$models,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Shopping']))
		{
			$model->attributes=$_POST['Shopping'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->shopping_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Shopping');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Shopping('search');
		$model->unsetAttributes();  // clear any default values
		$model->shopping_status=0;
		if(isset($_GET['Shopping']))
			$model->attributes=$_GET['Shopping'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionHtml()
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo "<style>";
		echo "table {";
			echo "border-collapse: collapse;";
		echo "}";
		
		echo "table, th, td {";
			echo "border: 1px solid black;";
			echo "vertical-align: text-top;";
			echo "text-align: center;";
		echo "}";
		echo "</style>";
		
		if (isset($_POST["check"]) && isset($_GET["act"])) {
			if ($_GET["act"] == "print_order") {
				$shopping=Shopping::model()->findAllByPk($_POST["check"],array(
					'with'=>'textileTextile',
					'together'=>true,
				));
				
				# weryfikujemy, czy zaznaczono zamówienia od tym samym numerze
				$sum=0;
				foreach ($shopping as $shopping_position) {
					$sum+=$shopping_position->shopping_number;
				}
				if ($sum/count($shopping) == $shopping[0]->shopping_number) {
					$shopping_number=$shopping[0]->shopping_number;
					
					# budujemy html
					$lp=0;
					echo "<table>";
						echo "<tr>";
						echo "<td>lp.</td>";
						echo "<td>nr mat. REALITY</td>";
						echo "<td>nazwa</td>";
						echo "<td>ilość</td>";
						echo "</tr>";
					foreach ($shopping as $shopping_position) {
						$lp+=1;
						echo "<tr>";
							echo "<td>";
								echo $lp;
							echo "</td>";
							echo "<td>";
								echo $shopping_position->textileTextile->textile_number;
							echo "</td>";
							echo "<td>";
								echo "&nbsp&nbsp" . $shopping_position->textileTextile->textile_name . "&nbsp&nbsp";
							echo "</td>";
							echo "<td>";
								if (!empty($shopping_position->article_amount)) {
									echo "&nbsp&nbsp" . $shopping_position->article_amount . "&nbsp&nbsp";
								} else {
									echo "&nbsp&nbsp" . $shopping_position->article_calculated_amount . "&nbsp&nbsp";
								}
							echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "Zaznaczono pozycje o różnych numerach zamówień";
				}
			}
		}
	}
	
	public function actionPrint()
	{
		if (isset($_POST["check"]) && isset($_GET["act"])) {
			if ($_GET["act"] == "print_order") {
				$shopping=Shopping::model()->findAllByPk($_POST["check"],array(
						'with'=>'textileTextile',
						'together'=>true,
				));
	
				# weryfikujemy, czy zaznaczono zamówienia od tym samym numerze
				$sum=0;
				foreach ($shopping as $shopping_position) {
					$sum+=$shopping_position->shopping_number;
				}
				if ($sum/count($shopping) == $shopping[0]->shopping_number) {
					$shopping_number=$shopping[0]->shopping_number;
					$shopping_lang=$shopping[0]->textileTextile->supplierSupplier->supplier_lang;
					
					# parametry PDF
					$pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf','P', 'mm', 'A4', true, 'UTF-8');
					$pdf->getAliasNbPages();
					$pdf->SetAuthor("Firma Wyrwał Daniel");
					$pdf->SetCreator("WD15");
					$pdf->SetSubject("Zamówienie materiałów");
					$pdf->SetTitle("zam. mat.");
					$pdf->SetKeywords("WD15, zamówienie, materiałów");
					
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(false);
					$pdf->SetMargins(5,5,5,true);
					
					$pdf->AddPage();
					$pdf->SetFont("FreeSans", "", 12);
					//$pdf->SetFont("DejaVuSans", "", 12);
					$pdf->setCellMargins(0, 0, 0, 0);
					$pdf->setCellPaddings(1, 1, 1, 1);
					
					# nagłowek dokumentu
					// Image ($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array())
					//$pdf->Image (Yii::app()->basePath."/../images/Logo WD.png", $x='', $y='', $w=0, $h=32, $type='', $link='', $align='T', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array());
					
					//ImageSVG ($file, $x='', $y='', $w=0, $h=0, $link='', $align='', $palign='', $border=0, $fitonpage=false)
					$pdf->ImageSVG(Yii::app()->basePath."/../images/Logo WD.svg", $x='', $y='', $w=0, $h=32, $link='', $align='T', $palign='', $border=0, $fitonpage=false);
					$txt = <<<EOT
Daniel Wyrwał
Silna 27
66-330 Pszczew
NIP PL 595-10-36-394
tel. +48 781 494 785
e-mail: wyrwal.daniel@gmail.com
EOT;
					$pdf->SetX($pdf->GetX()+5);
					// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
					$pdf->MultiCell(0, 50, $txt, 0, 'L', 0, 1, '', '', true, 1);
					
					if ($shopping_lang == "pl") {
						$txt="Zamówienie nr: $shopping_number";
					} else if ($shopping_lang == "en") {
						$txt="Order No: $shopping_number";
					} else {
						$txt="Bestellung: $shopping_number";
					}
					// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
					$pdf->Cell(0, 20, $txt, 0, 1, 'C', false, '', 0, false, 'T', 'T');
					
					# parametry tabeli
					$w=array(
						0 => 10,
						1 => 35,
						2 => 125,
						3 => 30
					);
					$h=0;
					
					# nagłówki
					if ($shopping_lang == "pl") {
						$headers=array(
							'lp.',
							'nr mat. REALITY',
							'nazwa',
							'ilość [mb]'
						);
					} else if ($shopping_lang == "en") {
						$headers=array(
							'lp.',
							'number',
							'name',
							'count [m]'
						);
					} else {
						$headers=array(
							'lp.',
							'Materialnummer',
							'Name',
							'Menge [m]'
						);
					}
					
					
					## ustalamy najwyższy "MultiCell"
					$textHeight=0;
					$lines=0;
					foreach ($headers as $index => $header) {
						// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
						if ($textHeight < $pdf->getStringHeight($w[$index], $header)) {
							$textHeight=$pdf->getStringHeight($w[$index], $header);
						}
					};
					
					## drukujemy
					// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
					$pdf->MultiCell($w[0], $textHeight, $headers[0], 1, 'C', 0, 0, '', '', true, 1);
					$pdf->MultiCell($w[1], $textHeight, $headers[1], 1, 'C', 0, 0, '', '', true, 1);
					$pdf->MultiCell($w[2], $textHeight, $headers[2], 1, 'C', 0, 0, '', '', true, 1);
					$pdf->MultiCell($w[3], $textHeight, $headers[3], 1, 'C', 0, 1, '', '', true, 1);
					
					# wiersze
					$lp=0;
					
					
					foreach ($shopping as $shopping_position) {
						$lp+=1;
						if (!empty($shopping_position->article_amount)) {
							$count=$shopping_position->article_amount;
						} else {
							$count=$shopping_position->article_calculated_amount;
						}
					
						# teksty
						$texts=array(
								$lp,
								$shopping_position->textileTextile->textile_number,
								$shopping_position->textileTextile->textile_name,
								$count
						);
							
						## ustalamy najwyższy "MultiCell" - wysokośc lub liczba wierszy
						$textHeight=0;
						$lines=0;
						foreach ($texts as $index => $text) {
							// getStringHeight ($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0)
							if ($textHeight < $pdf->getStringHeight($w[$index], $text)) {
								$textHeight=$pdf->getStringHeight($w[$index], $text);
							}
						};
						
						$pdf->MultiCell($w[0], $textHeight, $texts[0], 1, 'C', 0, 0, '', '', true, 1);
						$pdf->MultiCell($w[1], $textHeight, $texts[1], 1, 'C', 0, 0, '', '', true, 1);
						$pdf->MultiCell($w[2], $textHeight, $texts[2], 1, 'C', 0, 0, '', '', true, 1);
						$pdf->MultiCell($w[3], $textHeight, $texts[3], 1, 'C', 0, 1, '', '', true, 1);
					}
					
					#Drukujemy - w sensie tworzymy plik PDF
					#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
					$pdf->Output("Zam. mat.: $shopping_number " . date('Y-m-d') . ".pdf", "I");
					
					# oznaczamy pozycje jako wydrukowane
					foreach ($shopping as $shopping_position) {
						$shopping_position->shopping_status="wydrukowane";
						$shopping_position->save();
					}
				} else {
					echo "Zaznaczono pozycje o różnych numerach zamówień";
				}
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Shopping the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Shopping::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Shopping $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shopping-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
