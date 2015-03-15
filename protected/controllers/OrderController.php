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
		// Instanciation of inherited class
		$pdf = new PDF('L','mm','A4');
		$pdf->SetAutoPageBreak(true, 5);
		$pdf->AliasNbPages();
	
		$pdf->SetAuthor("Firma Wyrwał Daniel",1);
		$pdf->SetCreator("WD15",1);
		$pdf->SetSubject("Etykieta transportowa");
		$pdf->SetDisplayMode("fullpage","continuous");
	
		$pdf->AddPage();
		$pdf->SetMargins(5, 5, 5);
		
		//Podział na 4 - Rec(x, y, w, h)
		//szerokość		
		//(297-10)/2=143,5
		//wysokość
		//(210-10)/2=100
		//$pdf->Rect(5, 5, 143.5, 100);
		//$pdf->Rect(148.5, 5, 143.5, 100);
		//$pdf->Rect(5, 105, 143.5, 100);
		//$pdf->Rect(148.5, 105, 143.5, 100);
		
		//Linie do wycinania
		$pdf->Line(148.5, 5, 148.5, 205);
		$pdf->Line(5, 105, 292, 105);

		//Pierwsza ćwiartka
		$pdf->SetFont('arial_ce','B',18);
		$pdf->SetXY(5,5);
		//Cell(w, h, border, ln)
		$pdf->Cell(143.5, 8, "REALITY IMPORT GMBH", 0, 1, "C");
		
		//lewa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->Rect(5, 13, 143.5, 20);
		$pdf->Cell(143.5, 5, "Model:", 0, 1, "L");
		$pdf->Cell(143.5, 5, "Dessin:", 0, 1, "L");
		$pdf->Cell(143.5, 5, "Variant:", 0, 1, "L");
		$pdf->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße:"), 0, 1, "L");
		$pdf->Cell(143.5, 5, "", 0, 1, "L");
		
		$pdf->Cell(143.5, 5, "Empfanger:", 0, 1, "L");
		$pdf->Cell(143.5, 5, "Nazwa firmy", 0, 1, "L");
		$pdf->Cell(143.5, 5, "", 0, 1, "L");
		
		$pdf->Rect(5, 53, 71.75, 40);
		$pdf->Rect(76.75, 53, 71.75, 40);
		$pdf->Cell(71.75, 5, "Auftrag - nr", 0, 1, "L");
		$pdf->Cell(71.75, 5, "Bestellnummer", 0, 1, "L");
		$pdf->Cell(71.75, 5, "Lieferanschrift", 0, 1, "L");
		$pdf->Cell(71.75, 5, "", 0, 1, "L");
		$pdf->Cell(71.75, 5, "Nazwa firmy", 0, 1, "L");
		$pdf->Cell(71.75, 5, "Ulica", 0, 1, "L");
		$pdf->Cell(71.75, 5, "Kod pocztowy", 0, 1, "L");
		
		//Stopka z numeracją etykiet
		//$pdf->Rect(5, 98, 71.75, 10);
		$pdf->Cell(143.5, 5, "", 0, 1, "L");
		$pdf->Cell(143.5, 5, "", 0, 1, "L");
		$pdf->SetX(148.5-50);
		$pdf->Cell(50, 5, "1        von        1", 1, 1, "C");
		$pdf->Cell(143.5, 5, "", 0, 1, "L");
		
		//Prawa strona
		$pdf->SetXY(76.75, 38);
		$pdf->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		
		$pdf->SetXY(76.75, 53);
		$pdf->Cell(71.75, 5, "Artikel - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Model", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "EAN Nummer", 0, 2, "L");
		
		//Druga ćwiartka
		$pdf->SetFont('arial_ce','B',18);
		$pdf->SetXY(5+143.5,5);
		//Cell(w, h, border, ln)
		$pdf->Cell(143.5, 8, "REALITY IMPORT GMBH", 0, 2, "C");
		
		//lewa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->Rect(5+143.5, 13, 143.5, 20);
		$pdf->Cell(143.5, 5, "Model:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Dessin:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Variant:", 0, 2, "L");
		$pdf->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße:"), 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Cell(143.5, 5, "Empfanger:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Rect(5+143.5, 53, 71.75, 40);
		$pdf->Rect(76.75+143.5, 53, 71.75, 40);
		$pdf->Cell(71.75, 5, "Auftrag - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Bestellnummer", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Lieferanschrift", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Ulica", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Kod pocztowy", 0, 2, "L");
		
		//Stopka z numeracją etykiet
		//$pdf->Rect(5, 98, 71.75, 10);
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->SetX(148.5+143.5-50);
		$pdf->Cell(50, 5, "1        von        1", 1, 2, "C");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		//Prawa strona
		$pdf->SetXY(76.75+143.5, 38);
		$pdf->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		
		$pdf->SetXY(76.75+143.5, 53);
		$pdf->Cell(71.75, 5, "Artikel - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Model", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "EAN Nummer", 0, 2, "L");
		
 		//Trzecia ćwiartka
		//Prawa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->SetXY(76.75, 38+100);
		$pdf->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		
		$pdf->SetXY(76.75, 73-5);
		$pdf->Cell(71.75, 5, "Artikel - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Model", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "EAN Nummer", 0, 2, "L");

		$pdf->SetFont('arial_ce','B',18);
		$pdf->SetXY(5,5+100);
		//Cell(w, h, border, ln)
		$pdf->Cell(143.5, 8, "REALITY IMPORT GMBH", 0, 2, "C");
		
		//lewa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->Rect(5, 13+100, 143.5, 20);
		$pdf->Cell(143.5, 5, "Model:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Dessin:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Variant:", 0, 2, "L");
		$pdf->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße:"), 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Cell(143.5, 5, "Empfanger:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Rect(5, 53+100, 71.75, 40);
		$pdf->Rect(76.75, 53+100, 71.75, 40);
		$pdf->Cell(71.75, 5, "Auftrag - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Bestellnummer", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Lieferanschrift", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Ulica", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Kod pocztowy", 0, 2, "L");
		
		//Stopka z numeracją etykiet
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->SetX(148.5-50);
		$pdf->Cell(50, 5, "1        von        1", 1, 2, "C");

		//Trzecia ćwiartka
		//Prawa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->SetXY(76.75+143.5, 38+100);
		$pdf->Cell(71.75, 5, "Lieferant:", 0, 2, "L");
		
		$pdf->SetXY(76.75+143.5, 73-5);
		$pdf->Cell(71.75, 5, "Artikel - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Model", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "EAN Nummer", 0, 2, "L");
		
		$pdf->SetFont('arial_ce','B',18);
		$pdf->SetXY(5+143.5,5+100);
		//Cell(w, h, border, ln)
		$pdf->Cell(143.5, 8, "REALITY IMPORT GMBH", 0, 2, "C");
		
		//lewa strona
		$pdf->SetFont('arial_ce','',12);
		$pdf->Rect(5+143.5, 13+100, 143.5, 20);
		$pdf->Cell(143.5, 5, "Model:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Dessin:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Variant:", 0, 2, "L");
		$pdf->Cell(143.5, 5, iconv('utf-8', 'windows-1250',"Füße:"), 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Cell(143.5, 5, "Empfanger:", 0, 2, "L");
		$pdf->Cell(143.5, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		
		$pdf->Rect(5+143.5, 53+100, 71.75, 40);
		$pdf->Rect(76.75+143.5, 53+100, 71.75, 40);
		$pdf->Cell(71.75, 5, "Auftrag - nr", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Bestellnummer", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Lieferanschrift", 0, 2, "L");
		$pdf->Cell(71.75, 5, "", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Nazwa firmy", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Ulica", 0, 2, "L");
		$pdf->Cell(71.75, 5, "Kod pocztowy", 0, 2, "L");
		
		//Stopka z numeracją etykiet
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->Cell(143.5, 5, "", 0, 2, "L");
		$pdf->SetX(148.5+143.5-50);
		$pdf->Cell(50, 5, "1        von        1", 1, 2, "C");
		
		$pdf->Close();
		
	
		#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
		$pdf->Output("SZOiS-protokół_przekazania: " . ".pdf", "I");
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
