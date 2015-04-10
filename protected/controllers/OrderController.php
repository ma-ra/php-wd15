<?php

class OrderController extends Controller
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
				'actions'=>array('index','view', 'create', 'update', 'admin', 'delete','print','upload', 'mobileScaned', 'checked'),
				'users'=>array('*'),
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
		$model=new Order;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUpload()
	{
		$model=new UploadForm;
		$linia=array();
		
		if(isset($_POST['UploadForm']))
		{
			$model->attributes=$_POST['UploadForm'];
			$model->file=CUploadedFile::getInstance($model,'file');
			$model->file_extension=isset($model->file->extensionName)? $model->file->extensionName : " ";
			$model->file_mime=isset($model->file->type)? $model->file->type : " ";
			$model->file_size=isset($model->file->size)? $model->file->size : " ";
			if ($model->validate()) {
				$file=$model->file->tempName;
				
				#Odczytywanie pliku i zapis zamówień do bazy
				echo "<pre>";
				$handle = @fopen($file, "r");
				$i=1;
				$currentDate=date('Y-m-d H:i:s');
				
				
				$transaction = Yii::app()->db->beginTransaction();
				try {
					if ($handle) {
						while (($buffer = fgets($handle, 4096)) !== false) {
							$line=explode("^",$buffer);
							if ($line[0] != 75007) {
								continue;
							}
							/* echo $i++ . " ### " . $buffer;
							echo "          ";
							foreach ($line as $key => $value) {
								echo $key . "=>" . $value . "   ";
							} */
					
							$buyer=new Buyer('upload');
							$buyer->buyer_name_1=$line[5];
							$buyer->buyer_name_2=$line[6];
							$buyer->buyer_street=$line[7];
							$buyer->buyer_zip_code=$line[8];
							$buyer->save();
							
							$broker=new Broker('upload');
							$broker->broker_name="Reality Import GmbH";
							$broker->save();
							
							$manufacturer=new Manufacturer('upload');
							$manufacturer->manufacturer_number=$line[0];
							$manufacturer->manufacturer_name=$line[1];
							$manufacturer->save();
							
							$leg=new Leg('upload');
							$leg->leg_type=$line[14];
							$leg->save();
							
							$article=new Article('upload');
							$article->article_colli=1;
							$article->article_number=$line[11];
							$article->model_name=$line[12];
							$article->model_type=$line[13];
							$article->save();
							
							
							#Pierwszy deseń
							$textile=new Textile('upload');
							if ($line[15]>999) { #Jeden deseń na zamówieniu
								$textile->textile_number=$line[15];
								$textile->textile_price_group=$line[18];
							} else { #Dwa desenie na zamówieniu
								preg_match('/([0-9]{4})/i',$line[16],$matches);
								$textile->textile_number=$matches[1];
								$textile->textile_price_group=0; #przy dwuch, mamy grupę dla dwuch materiałów i zapisujemy gdzie indziej
							}
							$textile->textile_name=$line[16];
							$textile->save();
							
							#Drugi deseń
							if ($line[15]<=999) {
								$textile2=new Textile('upload');
								preg_match('/([0-9]{4})/i',$line[17],$matches);
								$textile2->textile_number=$matches[1];
								$textile2->textile_name=$line[17];
								$textile2->textile_price_group=0; #przy dwuch, mamy grupę dla dwuch materiałów i zapisujemy gdzie indziej
								$textile2->save();
							}
							
							
							#order - update or insert
							$order=Order::model()->find(array(
							'condition'=>'order_number=:order_number AND article_article_id=:article_id',
							'params'=>array(':order_number'=>$line[3], ':article_id'=>$article->article_id),
							#ostatni element
							'order' => "order_id DESC",
							'limit' => 1
							));
							if (empty($order) && $this->scenario === 'upload') {
								$order=new Order('upload');
							}
							$order->article_amount=$line[24];
							$order->buyer_comments=$line[10];
							$order->buyer_order_number=$line[9];
							$order->order_date=$line[4];
							$order->order_number=$line[3];
							$order->order_reference=$line[19];
							$order->order_term=$line[22];
							$order->article_article_id=$article->article_id;
							$order->leg_leg_id=$leg->leg_id;
							#Jeżeli mamy dwa desenie							
							if ($line[15]<=999) {
								$order->textil_pair=$line[15];
								$order->textilpair_price_group=$line[18];
								$order->textile2_textile_id=$textile2->textile_id;
							} else {
								$order->textile2_textile_id=null;
							}
							#Pierwszy deseń zawsze zapisuj
							$order->textile1_textile_id=$textile->textile_id;
							$order->buyer_buyer_id=$buyer->buyer_id;
							$order->broker_broker_id=$broker->broker_id;
							$order->manufacturer_manufacturer_id=$manufacturer->manufacturer_id;
							$order->order_add_date=$currentDate;
							$order->save();
							
						}
						fclose($handle);
						unlink($file);
					}
					echo "</pre>";
					$transaction->commit();
					echo "Done";
				} catch(Exception $e) {
					$transaction->rollBack();
					echo "Nie udało się: " . var_dump($e);
				}
			}
		}
		
		$this->render('upload',array('model'=>$model));
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
		$dataProvider=new CActiveDataProvider('Order');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		$model->unsetAttributes();  // clear any default values
		$model->article_exported=0;
		$model->article_canceled=0;
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionChecked()
	{
		if (isset($_POST["checked"]) && isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($id);
				if ($Order->checked==0) {
					$Order->checked=1;
				} else {
					$Order->checked=0;					
				}
				$Order->save();
			}
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		
		if (isset($_POST["prepared"]) && isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($id);
				if ($Order->textile_prepared==0) {
					$Order->textile_prepared=1;
				} else {
					$Order->textile_prepared=0;
				}
				$Order->save();
			}
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		
		if (isset($_POST["manufactured"]) && isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($id);
				if ($Order->article_manufactured==0) {
					$Order->article_manufactured=1;
				} else {
					$Order->article_manufactured=0;
				}
				$Order->save();
			}
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		
		if (isset($_POST["canceled"]) && isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($id);
				if ($Order->article_canceled==0) {
					$Order->article_canceled=1;
				} else {
					$Order->article_canceled=0;
				}
				$Order->save();
			}
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}
	
	public function actionMobileScaned() {
		if (isset($_POST["data"])) {
			#zdekodowanie otrzymanych danych
			$json = json_decode($_POST["data"]);
			
			#liczymy ilości w tablicy, a dopiero póniej zapisujemy policzone do bazy
			$orders=array();
			foreach ($json->values as $key => $values) {
				$id=substr($values, 0, 7);
				$count=substr($values, 7, 3);
				$coli=substr($values, 10, 1);
				$coli_amount=substr($values, 11, 1);
				
				#inicjujemy indeks, na potrzeby dalszej inkrementacji
				if (!array_key_exists($id, $orders)) {
					$orders[$id]["count"] = 0;
					$orders[$id]["coli"] = 0;
				} 
				
				$orders[$id]["coli"]+=1;
				
				if ($coli_amount == 1) {
					$orders[$id]["count"]+=1;
				} else if ($coli_amount == 2) {
					$orders[$id]["count"]+=0.5;
				} else if ($coli_amount == 3) {
					if ($coli == 3) {
						$orders[$id]["count"]+=0.4;
					} else {
						$orders[$id]["count"]+=0.3;
					}
				} else if ($coli_amount == 4) {
					$orders[$id]["count"]+=0.25;
				}
			}
			
			#zapis danych do bazy
			$totalColi=0;
			$totalCount=0;
			$totalBadColi=0;
			$totalBadCount=0;
			$badOrders=array();
			foreach ($orders as $key => $values) {
				$order=Order::model()->find(array(
					'condition'=>'order_id=:order_id',
					'params'=>array(':order_id'=>$key),
					#ostatni element
					'order' => "order_id DESC",
					'limit' => 1
				));
				
				if (empty($order)) {
					#przygotowanie odpowiedzi dla aplikacji w przypadku nieznanych kodów kreskowych
					$totalBadCount+=$values["count"];
					$totalBadColi+=$values["coli"];
					
					#pobranie listy kodów kreskowych
					foreach ($json->values as $nothing => $barcode) {
						$id=substr($barcode, 0, 7);
						if ($id == $key) {
							$badOrders[$barcode]=$barcode;
						}
					}
				} else {
					#zapis informacji do bazy w postaci procentów
					//wyliczenie obecnej liczby coli na podstawie procent będacych w bazie
					$currentPercentColi=$order->article_manufactured;
					//echo "$key %coli: $currentPercentColi\n";
					$currentColi=($order->article_manufactured * $order->article_amount * $order->articleArticle->article_colli)/100;
					//zwiększenie liczby coli o nowe skany
					//echo "$key  coli: $currentColi\n";
					$currentColi+=$values["coli"];
					//echo "$key  coli++: $currentColi\n";
					//wyliczenie procent i przypisane nowej wartości
					$order->article_manufactured=(100*$currentColi)/($order->article_amount*$order->articleArticle->article_colli);
					//echo $key . " %coli++: " . (100*$currentColi)/($order->article_amount*$order->articleArticle->article_colli) . "\n";
					
					$order->save();
					$totalCount+=$values["count"];
					$totalColi+=$values["coli"];
				}
			}
			
			#odpowiedź do aplikacji mobilnej
			if ($json->count == $totalCount * 100 && $json->coli == $totalColi * 100) {
				$return=array(
						'status' => 'OK',
						'coli' => $totalColi * 100,
						'count' =>$totalCount * 100,
				);
			} else {
				$return=array(
						'status' => 'PARTIAL',
						'coli' => $totalBadColi * 100,
						'count' =>$totalBadCount * 100,
						'values' => $badOrders
				);
			}
			echo json_encode($return, JSON_FORCE_OBJECT);
		} else {
			echo "Brak danych";
		}
		
		/* if (isset($_POST["data"])) {
			$json = json_decode($_POST["data"]);
			
			$return=array(
				'status' => 'PARTIAL',
				'coli' => $json->coli -1 *100,
				'count' =>$json->count -1 * 100,
				'values' => $json->values
			);
			echo json_encode($return, JSON_FORCE_OBJECT);
		} else {
			echo "false";
		} */
	}
	
	public function actionPrint()
	{
		#Mini etykiety
		if (isset($_POST) && isset($_POST["yt2"])) {
			if (isset($_POST["select"])) {
				#Przygotowanie wydruku
				// Instanciation of inherited class
				$pdf = new MiniLabel('P','mm','A4');
				$pdf->AliasNbPages();
				$pdf->SetMargins(10, 15, 5);
				$pdf->SetAutoPageBreak(true, 10);
					
				$pdf->SetAuthor("Firma Wyrwał Daniel",1);
				$pdf->SetCreator("WD15",1);
				$pdf->SetSubject("Mini etykiety");
				$pdf->SetDisplayMode("fullpage","continuous");
		
				$pdf->AddPage();
				$currentDate=date('Y-m-d H:i:s');
		
				foreach ($_POST["select"] as $id => $checked) {
					$Order=$this->loadModel($id);
					for ($i = 1; $i <= $Order->article_amount; $i++) {
						
						$pdf->orderNumber=$Order->order_number;
						$pdf->articleNumber=$Order->articleArticle->article_number;
						$pdf->articleName=$Order->articleArticle->model_name;
						$pdf->articleType=$Order->articleArticle->model_type;
						
						$textileNumber1=$Order->textile1Textile->textile_number;
						$textileName1= $Order->textile1Textile->textile_name;
						$textileNumber2=isset($Order->textile2Textile->textile_number) ? $Order->textile2Textile->textile_number : "" ;
						$textileName2=isset($Order->textile2Textile->textile_name) ? $Order->textile2Textile->textile_name : "" ;
						
						$pdf->textileNumber1=iconv('utf-8', 'windows-1250',$textileNumber1);
						$pdf->textileName1=iconv('utf-8', 'windows-1250',$textileName1);
						$pdf->textileNumber2=iconv('utf-8', 'windows-1250',$textileNumber2);
						$pdf->textileName2=iconv('utf-8', 'windows-1250',$textileName2);
						
						$pdf->orderDate=$Order->order_term;
						
						$pdf->DrawLine();
					}
					#Oznacz jako wydrukowane
					$Order->printed_minilabel=$currentDate;
					$Order->save();
				}
		
				$pdf->Close();
		
				#Drukujemy - w sensie tworzymy plik PDF
				#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
				$pdf->Output("Mini etykiety " . date('Y-m-d') . ".pdf", "I");
		
				/* echo "<pre>"; var_dump($_POST); echo "</pre>";
				die(); */
				} else {
				echo "Nic nie zaznaczono";
			}
		}
		
		#Ladeliste
		if (isset($_POST) && isset($_POST["yt1"])) {
			if (isset($_POST["select"])) {
				#Przygotowanie wydruku
				// Instanciation of inherited class
				$pdf = new LoadingList('P','mm','A4');
				$pdf->AliasNbPages();
				$pdf->SetMargins(10, 10, 10);
				$pdf->SetAutoPageBreak(true, 5);
					
				$pdf->SetAuthor("Firma Wyrwał Daniel",1);
				$pdf->SetCreator("WD15",1);
				$pdf->SetSubject("Lista załadunkowa");
				$pdf->SetDisplayMode("fullpage","continuous");
				
				$configuration=Configuration::model();
				$pdf->ladedatum=$configuration->findByAttributes(array('name'=>'ladedatum'))->value;
				$pdf->verladeliste_tour=$configuration->findByAttributes(array('name'=>'verladeliste_tour'))->value;
					
				$pdf->AddPage();
				
				$pdf->DrawHead();
				$i=0;
				$articleAmountSum=0;
				$articleColiSum=0;
				foreach ($_POST["select"] as $id => $checked) {
					$Order=$this->loadModel($id);
					
					$pdf->orderNumber=$Order->order_number;
					$pdf->modelName=$Order->articleArticle->model_name;
					$pdf->modelType=$Order->articleArticle->model_type;
					$pdf->textileNumber="";
					preg_match('/([A-Z].*[0-9])/i',$Order->buyerBuyer->buyer_zip_code,$matches);
					isset($matches[1])? $pdf->buyerZipCode=$matches[1] : $pdf->buyerZipCode=$Order->buyerBuyer->buyer_zip_code;
					$pdf->articleAmount=$Order->article_amount;
					$articleAmountSum=$articleAmountSum+$pdf->articleAmount;
					$pdf->articleColi=$Order->articleArticle->article_colli * $pdf->articleAmount;
					$articleColiSum=$articleColiSum+$pdf->articleColi;
					
					
					if (isset($Order->textil_pair)) {
						isset($Order->textil_pair)? $textile1=$Order->textil_pair : $textile1="";
					} else {
						isset($Order->textile1Textile->textile_number)? $textile1=$Order->textile1Textile->textile_number: $textile1="";
					}
					$pdf->textileNumber= $textile1;
					
					$i++;
					
					if (preg_match('/Musteranforderung/i',$Order->order_number)) {
						$textile1 = $textile1 . "; " . $Order->textile1Textile->textile_name;
						$textile2 = isset($Order->textile2Textile->textile_name) ? $Order->textile2Textile->textile_name : "";
						$pdf->textileNumber= $textile1 . "; " . $textile2;
					} 
					$pdf->DrawLine($i);

					#Oznacz jako wywiezione
					$Order->article_exported=$pdf->verladeliste_tour;
					$Order->save();
				
				}
				$pdf->articleAmount=$articleAmountSum;
				$pdf->articleColi=$articleColiSum;
				$pdf->DrawFooter();
				
				$pdf->Close();
				
				#Drukujemy - w sensie tworzymy plik PDF
				#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
				$pdf->Output("Ladeliste " . date('Y-m-d') . ".pdf", "I");
				
				/* echo "<pre>"; var_dump($_POST); echo "</pre>";
				die(); */
			} else {
				echo "Nic nie zaznaczono";
			}
		}
		
		#Etykiety transportowe
		if (isset($_POST) && isset($_POST["yt0"])) {
			if (isset($_POST["select"])) {
				#Przygotowanie wydruku
				// Instanciation of inherited class
				$pdf = new ShippingLabel('L','mm','A4');
				$pdf->AliasNbPages();
				$pdf->SetMargins(5, 5, 5);
				$pdf->SetAutoPageBreak(true, 5);
				
				$pdf->SetAuthor("Firma Wyrwał Daniel",1);
				$pdf->SetCreator("WD15",1);
				$pdf->SetSubject("Etykieta transportowa");
				$pdf->SetDisplayMode("fullpage","continuous");
				
				$pdf->AddPage();
				$currentDate=date('Y-m-d H:i:s');
				$pdf->DrawLine();
				$quarter=0;
				
				#Pętla po zaznaczonych zamówieniach
				foreach ($_POST["select"] as $id => $checked) {
					$Order=$this->loadModel($id);
					#Pętla po ilości
					for ($i = 1; $i <= $Order->article_amount; $i++) {
						#Pętla po colli
						for ($j = 1; $j <= $Order->articleArticle->article_colli; $j++) {
							#Odmieżanie ćwiartek i dodawanie stron
							$quarter=$quarter+1;
							if ($quarter==5) {
								$quarter=1;
								$pdf->AddPage();
								$pdf->DrawLine();
							}
							
							#Zebranie danych
							$pdf->model=$Order->articleArticle->model_name . " " . $Order->articleArticle->model_type;
							if(isset($Order->textil_pair)) {
								$dess1=$Order->textil_pair . "; " . $Order->textile1Textile->textile_name;
							} else {
								$dess1=$Order->textile1Textile->textile_number . "; " . $Order->textile1Textile->textile_name;
							}
							$dess2=isset($Order->textile2Textile->textile_name)? "; " . $Order->textile2Textile->textile_name : " ";
							$pdf->dessin=$dess1 . " " . $dess2;
							$pdf->variant="";
							$pdf->fusse=$Order->legLeg->leg_type;
							$pdf->empfanger=$Order->buyerBuyer->buyer_name_1;
							$pdf->lieferant=$Order->brokerBroker->broker_name;
							$pdf->auftragNr=$Order->order_number;
							$pdf->bestellnummer=$Order->buyer_order_number;
							$pdf->lieferanschrift="";
							$pdf->strasse=$Order->buyerBuyer->buyer_street;
							$pdf->plz=$Order->buyerBuyer->buyer_zip_code;
							$pdf->artikelNr=$Order->articleArticle->article_number;
							$pdf->eanNummer="";
							$pdf->number=$j;
							$pdf->totalNumber=$Order->articleArticle->article_colli;
				
							//odred_id + (3) sztuka + (1) no coli + (1) ilość coli
							$pdf->id=$Order->order_id . sprintf('%03d', $i) . $j . $Order->articleArticle->article_colli;
							
							#Rysujemy daną ćwiartkę
							$pdf->Draw($quarter);
							
						}
					}
					#Oznacz jako wydrukowane
					$Order->printed_shipping_label=$currentDate;
					$Order->save();
				}
				$pdf->Close();
				
				#Drukujemy - w sensie tworzymy plik PDF
				#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
				$pdf->Output("Etykiety transportowe " . date('Y-m-d') .  ".pdf", "I");
			} else {
				echo "Nic nie zaznaczono";
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Order the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Order $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
