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
				'actions'=>array('index','view','print'),
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
		if (isset($_POST)) {
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
						
						$pdf->model=$Order->articleArticle->model_name . " " . $Order->articleArticle->model_type;
						$dess1="1. Dess: " . $Order->textiles[0]->textile_number . " " . $Order->textiles[0]->textile_name;
						$dess2=isset($Order->textiles[1]->textile_number)? "/ 2. Dess: " . $Order->textiles[1]->textile_number . " " . $Order->textiles[1]->textile_name : " ";
						$dessin=$dess1 . " " . $dess2;
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
			
						#Rysujemy
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
