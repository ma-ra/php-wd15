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
				'actions'=>array('index','view','print','upload'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
					
							$buyer=new Buyer();
							$buyer->buyer_name_1=$line[5];
							$buyer->buyer_name_2=$line[6];
							$buyer->buyer_street=$line[7];
							$buyer->buyer_zip_code=$line[8];
							$buyer->save();
							
							$broker=new Broker();
							$broker->broker_name="Reality Import GmbH";
							$broker->save();
							
							$manufacturer=new Manufacturer();
							$manufacturer->manufacturer_number=$line[0];
							$manufacturer->manufacturer_name=$line[1];
							$manufacturer->save();
							
							$leg=new Leg();
							$leg->leg_type=$line[14];
							$leg->save();
							
							$article=new Article();
							$article->article_colli=1;
							$article->article_number=$line[11];
							$article->model_name=$line[12];
							$article->model_type=$line[13];
							$article->save();
							
							$order=new Order();
							$order->article_amount=$line[24];
							$order->buyer_comments=$line[10];
							if ($line[15]<=999) {
								$order->textile_order=$line[15];
							}
							$order->buyer_order_number=$line[9];
							$order->order_date=$line[4];
							$order->order_number=$line[3];
							$order->order_reference=$line[19];
							$order->order_term=$line[22];
							$order->article_article_id=$article->article_id;
							$order->leg_leg_id=$leg->leg_id;
							$order->buyer_buyer_id=$buyer->buyer_id;
							$order->broker_broker_id=$broker->broker_id;
							$order->manufacturer_manufacturer_id=$manufacturer->manufacturer_id;
							$order->save();
							
							$textile=new Textile();
							$order_has_textile=new OrderHasTextile();
							if ($line[15]>999) {
								$textile->textile_number=$line[15];
							} else {
								preg_match('/([0-9]{4})/i',$line[16],$matches);
								$textile->textile_number=$matches[1];
								$textile->textile_name=$line[16];
							}
							$textile->textile_name=$line[16];
							$textile->textile_price_group=$line[18];
							$textile->save();
							$order_has_textile->order_order_id=$order->order_id;
							$order_has_textile->textile_textile_id=$textile->textile_id;
							$order_has_textile->save();
							
							
							if ($line[15]<=999) {
								$textile2=new Textile();
								$order_has_textile2=new OrderHasTextile();
								preg_match('/([0-9]{4})/i',$line[17],$matches);
								$textile2->textile_number=$matches[1];
								$textile2->textile_name=$line[17];
								$textile2->textile_price_group=$line[18];
								$textile2->save();
								$order_has_textile2->order_order_id=$order->order_id;
								$order_has_textile2->textile_textile_id=$textile2->textile_id;
								$order_has_textile2->save();
							}
							
							
						}
						fclose($handle);
						unlink($file);
					}
					echo "</pre>";
					$transaction->commit();
					echo "Done";
				} catch(Exception $e) {
					$transaction->rollBack();
					echo "Nie udało się";
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
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionPrint()
	{
		if (isset($_POST) && isset($_POST["yt3"])) {
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
				$pdf->buyerZipCode=$matches[1];
				$pdf->articleAmount=$Order->article_amount;
				$articleAmountSum=$articleAmountSum+$pdf->articleAmount;
				$pdf->articleColi=$Order->articleArticle->article_colli * $pdf->articleAmount;
				$articleColiSum=$articleColiSum+$pdf->articleColi;
				//var_dump($Order->textiles[1]);
				$textile1=$Order->textiles[0]->textile_number;
				isset($Order->textiles[1]->textile_number)? $textile2="/".$Order->textiles[1]->textile_number: $textile2="";
				$pdf->textileNumber= $textile1 . $textile2;
				
				$i++;
				$pdf->DrawLine($i);
			}
			$pdf->articleAmount=$articleAmountSum;
			$pdf->articleColi=$articleColiSum;
			$pdf->DrawFooter();
			
			$pdf->Close();
			
			#Drukujemy - w sensie tworzymy plik PDF
			#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
			$pdf->Output("Etykiety transportowe: " . ".pdf", "I");
			
			/* echo "<pre>"; var_dump($_POST); echo "</pre>";
			die(); */
		}
		
		if (isset($_POST) && isset($_POST["yt2"])) {
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
						if(isset($Order->textile_order)) {
							$dess1=$Order->textile_order . "; " . $Order->textiles[0]->textile_name . ";";
						} else {
							$dess1=$Order->textiles[0]->textile_number . "; " . $Order->textiles[0]->textile_name;
						}
						$dess2=isset($Order->textiles[1]->textile_name)? "; " . $Order->textiles[1]->textile_name : " ";
						$pdf->dessin=$dess1 . " " . $dess2;
						$pdf->variant="";
						$pdf->fusse=$Order->legLeg->leg_type;
						$pdf->empfanger=$Order->buyerBuyer->buyer_name_1;
						$pdf->lieferant=$Order->brokerBroker->broker_name;
						$pdf->auftragNr=$Order->order_number;
						$pdf->bestellnummer=$Order->buyer_comments;
						$pdf->lieferanschrift="";
						$pdf->strasse=$Order->buyerBuyer->buyer_street;
						$pdf->plz=$Order->buyerBuyer->buyer_zip_code;
						$pdf->artikelNr=$Order->articleArticle->article_number;
						$pdf->eanNummer="";
						$pdf->number=$j;
						$pdf->totalNumber=$Order->articleArticle->article_colli;
			
						#Rysujemy daną ćwiartkę
						$pdf->Draw($quarter);
					}
				}
			}
		}
		
		$pdf->Close();
		
		#Drukujemy - w sensie tworzymy plik PDF
		#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
		$pdf->Output("Etykiety transportowe: " . ".pdf", "I");
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
