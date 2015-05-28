<?php

class WarehouseController extends Controller
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
				'actions'=>array('create','update', 'delete'),
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
		
		if(isset($_POST['Warehouse']))
		{
			# pętla po otrzymanych wierszach, tworzenie modelu do każdego wiersza i przypisanie atrybutów
			foreach ($_POST['Warehouse'] as $key => $model) {
				$models[$key]=new Warehouse;
				$models[$key]->attributes=$_POST['Warehouse'][$key];
				# nie weryfikuj oraz nie usówaj całkowicie pustych wierszy
				$attributes_count=0;
				foreach ($models[$key] as $attr_key => $attribute) {
					if (!empty($attribute)) {
						$attributes_count+=1;
					}
				}
				if ($attributes_count > 0) {
					# wyszukujemy powiązane zakupy
					$Shopping=Shopping::model()->findByPk($models[$key]->shopping_shopping_id);
					# jeżeli nie znaleziono, to nie ustawiaj
					if(empty($Shopping)) {
						$models[$key]->shopping_shopping_id=null;
					} 
					
					if($models[$key]->save()) {
						# zmieniamy status zamówienia, jeżeli podano id
						if ($models[$key]->article_count >= $Shopping->article_amount) {
							$Shopping->shopping_status="dostarczono";
						} else {
							$Shopping->shopping_status="częściowo";
						}
						$Shopping->save();
						
						# po poprawnym zapisie wyczyść prezentowany wiersz lub usuń 
						# wyczyść
						$models[$key]->unsetAttributes();
						# usuń
						//unset($models[$key]);
					}
				}
			}
		} else {
			# jak nie otrzymaliśmy wierszy, to sami je generujemy
			for ($i = 1; $i <= 15; $i++) {
				$models[$i]=new Warehouse;
			}
		}

		#jeżeli $models jest puste, to znaczy, że wszystko udało sie zapisać
		if (empty($models)) {
			$this->redirect(array('Warehouse/admin'));
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

		if(isset($_POST['Warehouse']))
		{
			$model->attributes=$_POST['Warehouse'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->warehouse_id));
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
		$dataProvider=new CActiveDataProvider('Warehouse');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Warehouse('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Warehouse']))
			$model->attributes=$_GET['Warehouse'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Warehouse the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Warehouse::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Warehouse $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='warehouse-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
