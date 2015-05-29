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
				'actions'=>array('create','update', 'delete', 'print'),
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
				$models[$key]->order_ids=$_POST['Shopping'][$key]['order_ids'];
				
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
				if (!isset($models[$key]->article_amount)) {
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
					# pozyskujemy id przemycony w polu status
					$order_ids=explode(",",$models[$key]->order_ids);
						
					if($models[$key]->save()) {
						# wiązemy zakupy (shopping) z zamówieniam (order)
						foreach ($order_ids as $order_id) {
							if (!empty($order_id)) {
								$Order=Order::model()->findByPk($order_id);
								$Order->shopping_shopping_id=$models[$key]->shopping_id;
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
	
	public function actionPrint()
	{
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
				$shopping=Shopping::model()->findAllByPk($_POST["check"]);
				
				# weryfikujemy, czy zaznaczono zamówienia od tym samym numerze
				$sum=0;
				foreach ($shopping as $shopping_position) {
					$sum+=$shopping_position->shopping_number;
				}
				if ($sum/count($shopping) == $shopping[0]->shopping_number) {
					$shopping_number=$shopping[0]->shopping_number;
					
					echo "<table>";
					foreach ($shopping as $shopping_position) {
						echo "<tr>";
							echo "<td>";
								echo "$shopping_position->article_amount";
							echo "</td>";
						echo "</tr>";
					}
					echo "</table>";
				} else {
					echo "Zaznaczono pozycje o różnych numerach zamówień";
				}
				echo "<pre>";
				echo "</pre>";
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
