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
				'actions'=>array('create', 'createMany', 'update', 'delete', 'print', 'html', 'delivered', 'partial', 'canceled'),
				'users'=>array('asia', 'mara', 'michalina'),
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
		$model=new Shopping;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Shopping']))
		{
			$model->attributes=$_POST['Shopping'];
			$model->shopping_status="nowy";
			$model->creation_time=date('Y-m-d H:i:s');
			if($model->save())
				$this->redirect(array('view','id'=>$model->shopping_id));
		}
		
		$this->render('create',array(
				'model'=>$model,
		));
	}

	public function actionCreateMany()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		# http://www.yiiframework.com/wiki/362/how-to-use-multiple-instances-of-the-same-model-in-the-same-form/
		$models=array();
		
		if(isset($_POST['Shopping']))
		{
			echo "<pre>";
			var_dump($_POST);
			echo "</pre>";
			
			# na początek ustalamy max numer zamówienia materiałów (zakupów)
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
				$models[$key]->order1_ids=isset($_POST['Shopping'][$key]['order1_ids']) ? $_POST['Shopping'][$key]['order1_ids'] : null;
				$models[$key]->order2_ids=isset($_POST['Shopping'][$key]['order2_ids']) ? $_POST['Shopping'][$key]['order2_ids'] : null;
				
				#jeżeli podano 0, to znaczy, że nie zamawiamy
				if ($models[$key]->article_amount == null || $models[$key]->article_amount == 0) {
					$models[$key]->unsetAttributes();
				}
				
				# nie weryfikuj oraz nie usówaj całkowicie pustych wierszy
				$attributes_count=0;
				foreach ($models[$key] as $attr_key => $attribute) {
					if (!empty($attribute)) {
						$attributes_count+=1;
					}
				}
				
				if ($attributes_count > 0) {
					#nadajemy numer
					$supplierId=isset(FabricCollection::model()->findByPk($models[$key]->fabric_collection_fabric_id)->supplierSupplier->supplier_id) ? FabricCollection::model()->findByPk($models[$key]->fabric_collection_fabric_id)->supplierSupplier->supplier_id : "-" ;
					if (!isset($shoppingNumber[$supplierId])) {
						$maxShoppingNumber+=1;
						$shoppingNumber[$supplierId]=$maxShoppingNumber;
					}
					
					# nadajemy status
					$models[$key]->shopping_status="nowy";
					$models[$key]->creation_time=date('Y-m-d H:i:s');
					
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
						# usuń z listy kontrolnej
						unset($check[$key]);
					}
				} else {
					# usówamy puste wiersze z listy kontrolnej
					unset($check[$key]);
				}
			}
		} 

		#jeżeli lista kontrolna jest pusta, to znaczy, że wszystko udało sie zapisać
		if (empty($check)) {
			$this->redirect(array('Shopping/admin', 'Shopping[shopping_status]'=>'nowy', 'sort'=>'shopping_id.desc'));
		}
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
		$this->layout='//layouts/orderAdmin';
		$model=new Shopping('search');
		$model->unsetAttributes();  // clear any default values
		$model->shopping_status='w trakcie';
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
					'with'=>'fabricCollectionFabric',
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
								echo $shopping_position->fabricCollectionFabric->fabric_number;
							echo "</td>";
							echo "<td>";
								echo "&nbsp&nbsp" . $shopping_position->fabricCollectionFabric->fabric_name . "&nbsp&nbsp";
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
						'with'=>'fabricCollectionFabric',
						'together'=>true,
				));
	
				# weryfikujemy, czy zaznaczono zamówienia od tym samym numerze
				$sum=0;
				foreach ($shopping as $shopping_position) {
					$sum+=$shopping_position->shopping_number;
				}
				if ($sum/count($shopping) == $shopping[0]->shopping_number) {
					$shopping_number=$shopping[0]->shopping_number;
					$supplier_name=$shopping[0]->fabricCollectionFabric->supplierSupplier->supplier_name;
					$shopping_lang=$shopping[0]->fabricCollectionFabric->supplierSupplier->supplier_lang;
					
					# parametry PDF
					$pdf = new ShoppingList('P', 'mm', 'A4', true, 'UTF-8');
					$pdf->getAliasNbPages();
					$pdf->SetAuthor("Firma Wyrwał Daniel");
					$pdf->SetCreator("WD15");
					$pdf->SetSubject("Zamówienie materiałów");
					$pdf->SetTitle("zam. mat.");
					$pdf->SetKeywords("WD15, zamówienie, materiałów");
					
					$pdf->SetDisplayMode("fullpage","OneColumn");
					$pdf->setPrintHeader(false);
					$pdf->setPrintFooter(true);
					$pdf->SetMargins(5,5,5,true);
					$pdf->SetAutoPageBreak(true,0);
					
					$pdf->creation_time=$shopping[0]->creation_time;
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
					$pdf->MultiCell(0, 0, $txt, 0, 'L', 0, 1, '', '', true, 1);
					$pdf->SetY($pdf->GetY()+5);
					
					if ($shopping_lang == "pl") {
						$txt="Zamówienie nr: $shopping_number ($supplier_name)";
					} else if ($shopping_lang == "en") {
						$txt="Order No: $shopping_number ($supplier_name)";
					} else {
						$txt="Bestellung: $shopping_number ($supplier_name)";
					}
					$pdf->SetFont("FreeSans", "B", 13);
					// Cell ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
					$pdf->Cell(0, 0, $txt, 0, 1, 'C', false, '', 0, false, 'T', 'T');
					$pdf->SetFont("FreeSans", "", 12);
					$pdf->SetY($pdf->GetY()+5);
					
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
						# kolejna strona
						if ($pdf->GetY()>=297-12) {
							$pdf->AddPage();
						}
						
						$lp+=1;
						if (!empty($shopping_position->article_amount)) {
							$count=$shopping_position->article_amount;
						} else {
							$count=$shopping_position->article_calculated_amount;
						}
					
						# teksty
						$texts=array(
								$lp,
								$shopping_position->fabricCollectionFabric->fabric_number,
								$shopping_position->fabricCollectionFabric->fabric_name,
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
					$date=date('Y-m-d H:i:s');
					foreach ($shopping as $shopping_position) {
						$shopping_position->shopping_status="wydrukowane";
						$shopping_position->shopping_printed=$date;
						$shopping_position->save();
					}
				} else {
					echo "Zaznaczono pozycje o różnych numerach zamówień";
				}
			}
		}
	}
	
	public function actionDelivered()
	{
		if (isset($_POST["check"])) {
			foreach ($_POST["check"] as $id => $checked) {
				$Shopping=$this->loadModel($checked);
				$Shopping->article_delivered_amount=$Shopping->article_amount;
				$Shopping->shopping_delivery_date=date('Y-m-d H:i:s');
				$Shopping->shopping_status="dostarczono";
				$Shopping->save();
			}
		} else {
			print_r($_REQUEST);
		}
	}
	
	public function actionPartial()
	{
		if (isset($_POST["check"])) {
			foreach ($_POST["check"] as $id => $checked) {
				$Shopping=$this->loadModel($checked);
				$Shopping->shopping_delivery_date=date('Y-m-d H:i:s');
				$Shopping->shopping_status="częściowo";
				$Shopping->save();
			}
		} else {
			print_r($_REQUEST);
		}
	}
	
	public function actionCanceled()
	{
		if (isset($_POST["check"])) {
			foreach ($_POST["check"] as $id => $checked) {
				$Shopping=$this->loadModel($checked);
				$Shopping->shopping_status="anulowano";
				$Shopping->save();
			}
		} else {
			print_r($_REQUEST);
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
