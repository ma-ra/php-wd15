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
				'actions'=>array('index','view', 'update', 'admin', 'checked', 'manufactured', 
						         'prepared', 'canceled', 'summary', 'textileSummary', 'print', 'printPlan'),
				'users'=>array('asia', 'gosia', 'mara', 'mariola', 'pawel'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('create', 'admin2', 'delete', 'upload', 'printOrdersWithPrice', 'searchTextiles'),
					'users'=>array('mara','asia'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('mobileScaned'),
					# wpuszczamy wszystkich ponieważ wd15-mobile nie radzi sobie z autoryzacją w tym miejscu
					# cała aplikacja i tak jest chroniona hasłem w htaccess, co działa z aplikacją mobilną
					'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			# w view->admin kontrlouję widocznośc kloumny z cenami na podstawie loginu
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
				# usuń dotychczasowe błędy typu: exported
				$exported=Order::model()->findAll(array(
					'condition'=>'order_error like :exported',
					'params'=>array(':exported'=>'%exported%'),
				));
				
				$transaction = Yii::app()->db->beginTransaction();
				try {
					foreach ($exported as $key => $order) {
						$error=explode("|", $order->order_error);
						if (in_array("exported", $error)) {
							$error = array_diff($error, array("exported"));
							$error=implode("|", $error);
							$order->order_error=$error;
							$order->save();
						}
					}
					
					$transaction->commit();
					Yii::app()->user->setFlash('1success','Poprawnie skasowane stare błędy typu: "exported".');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('1error','Nie udało się skasować błędów typu: "exported".');
				}
				
				
				$file=$model->file->tempName;
				#####
				# Odczytywanie pliku i zapis zamówień do bazy
				#####
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
							
							####
							# Buyer - update or insert
							####
							$buyer=Buyer::model()->find(array(
								'condition'=>'buyer_name_1=:name1 AND buyer_name_2=:name2 AND buyer_street=:street AND buyer_zip_code=:zip_code',
								'params'=>array(':name1'=>$line[5], 
									':name2'=>$line[6],
					 				':street'=>$line[7],
									':zip_code'=>$line[8],
								),
								# ostatni element
								'order' => "buyer_id DESC",
								'limit' => 1
							));
							if (empty($buyer)) {
								$buyer=new Buyer('upload');
							}
							$buyer->buyer_name_1=$line[5];
							$buyer->buyer_name_2=$line[6];
							$buyer->buyer_street=$line[7];
							$buyer->buyer_zip_code=$line[8];
							$buyer->save();
							
							####
							# Broker - update or insert
							####
							$broker=Broker::model()->find(array(
								'condition'=>'broker_name=:name',
								'params'=>array(':name'=>'Reality Import GmbH'),
								# ostatni element
								'order' => "broker_id DESC",
								'limit' => 1
							));
							if (empty($broker)) {
								$broker=new Broker('upload');
							}
							$broker->broker_name="Reality Import GmbH";
							$broker->save();
							
							####
							# Manufacturer - update or insert
							####
							$manufacturer=Manufacturer::model()->find(array(
								'condition'=>'manufacturer_name=:name AND manufacturer_number=:number',
								'params'=>array(':name'=>$line[1],
												':number'=>$line[0],
								),
								# ostatni element
								'order' => "manufacturer_id DESC",
								'limit' => 1
							));
							if (empty($manufacturer)) {
								$manufacturer=new Manufacturer('upload');
							}
							$manufacturer->manufacturer_number=$line[0];
							$manufacturer->manufacturer_name=$line[1];
							$manufacturer->save();
							
							####
							# Leg - update or insert
							####
							$leg=Leg::model()->find(array(
								'condition'=>'leg_type=:leg',
								'params'=>array(':leg'=>$line[14]),
								#ostatni element
								'order' => "leg_id DESC",
								'limit' => 1
							));
							if (empty($leg)) {
								$leg=new Leg('upload');
							}
							$leg->leg_type=$line[14];
							$leg->save();
							
							####
							# Article - update or insert
							####
							$article=Article::model()->find(array(
								'condition'=>'article_number=:number',
								'params'=>array(':number'=>$line[11]),
								#ostatni element
								'order' => "article_id DESC",
								'limit' => 1
							));
							if (empty($article)) {
								$article=new Article('upload');
								$article->article_colli=1;
								$article->model_name=$line[12];
								$article->model_type=$line[13];
							}
							$article->article_number=$line[11];
							$article->save();
							
							# pierwszy deseń
							if ($line[15]>999) { #Jeden deseń na zamówieniu
								$textile_number=$line[15];
								$textile_price_group=$line[18];
							} else { # dwa desenie na zamówieniu
								preg_match('/([0-9]{4})/i',$line[16],$matches);
								$textile_number=$matches[1];
								$textile_price_group=0; #przy dwuch, mamy grupę dla dwuch materiałów i zapisujemy gdzie indziej
							}
							
							####
							# Textile - update or insert
							####
							$textile=Textile::model()->find(array(
								'condition'=>'textile_number=:number AND textile_name=:name AND textile_price_group=:group',
								'params'=>array(':number'=>$textile_number,
												':name'=>$line[16],
												':group'=>$textile_price_group,
								),
								#ostatni element
								'order' => "textile_id DESC",
								'limit' => 1
							));
							if (empty($textile)) {
								$textile=new Textile('upload');
							}
							$textile->textile_number=$textile_number;
							$textile->textile_price_group=$textile_price_group;
							$textile->textile_name=$line[16];
							$textile->save();
							
							# drugi deseń
							if ($line[15]<=999) {
								preg_match('/([0-9]{4})/i',$line[17],$matches);
								# textile2 - update or insert
								$textile2=Textile::model()->find(array(
									'condition'=>'textile_number=:number AND textile_name=:name AND textile_price_group=:group',
									'params'=>array(':number'=>$matches[1],
									':name'=>$line[17],
									':group'=>0,
									),
									# ostatni element
									'order' => "textile_id DESC",
									'limit' => 1
								));
								if (empty($textile2)) {
									$textile2=new Textile('upload');
								}
								$textile2->textile_number=$matches[1];
								$textile2->textile_name=$line[17];
								$textile2->textile_price_group=0; #przy dwuch, mamy grupę dla dwuch materiałów i zapisujemy gdzie indziej
								$textile2->save();
							}
							
							####
							# Order - update or insert
							####
							$order=Order::model()->find(array(
								'condition'=>'order_number=:order_number AND article_article_id=:article_id',
								'params'=>array(':order_number'=>$line[3], ':article_id'=>$article->article_id),
								#ostatni element
								'order' => "order_id DESC",
								'limit' => 1
							));
							if (empty($order)) {
								$order=new Order('upload');
								# jak nowy, to ustaw datę wgrania, w przeciwnym wypadku zostanie poprzednia data wgrania
								$order->order_add_date=$currentDate;
							}
							$order->order_storno_date=$currentDate;
							# oznacz zmianę ilości
							if (isset($order->article_amount) && $order->article_amount != $line[24]) {
								$error=explode("|", $order->order_error);
								array_push ( $error , "amount-$order->article_amount");
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							# dalsze przetwarzanie wczytywania zamówienia
							$order->order_price=$line[23];
							$order->article_amount=$line[24];
							$order->order_total_price=$line[25];
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
							# pierwszy deseń zawsze zapisuj
							$order->textile1_textile_id=$textile->textile_id;
							$order->buyer_buyer_id=$buyer->buyer_id;
							$order->broker_broker_id=$broker->broker_id;
							$order->manufacturer_manufacturer_id=$manufacturer->manufacturer_id;
							
							# oznacz niepoprawne storno
							if (isset($order->article_canceled) && $order->article_canceled != 0) {
								$error=explode("|", $order->order_error);
								if (!in_array("false storno", $error)) {
									array_push ( $error , "false storno");
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							# oznacz błąd typu "exported" - zamówienie dla towaru który wyjechał
							if (isset($order->article_exported) && $order->article_exported != null) {
								$error=explode("|", $order->order_error);
								if (!in_array("exported", $error)) {
									array_push ( $error , "exported");
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							$order->save();
							
						}
						fclose($handle);
						unlink($file);
					}
					$transaction->commit();
					Yii::app()->user->setFlash('2success','Zamówienia wgrane bez błędów.');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('2error','Nie udało się wgrać zamówień.');
					echo "<pre>"; var_dump($e); echo "</pre>";
				}
				
				# wyszukaj potencjalne storna
				$stornos=Order::model()->findAll(array(
				'condition'=>'article_exported is NULL AND article_canceled = 0 AND order_storno_date != :currentDate',
				'params'=>array(':currentDate'=>$currentDate),
				));
		
				# oznacz odnalezione storna za pomocą błędu: storno
				$transaction = Yii::app()->db->beginTransaction();
				try {
					foreach ($stornos as $key => $storno) {
						#Dodanie kolejnego błędu (bez dubli)
						$error=explode("|", $storno->order_error);
						if (!in_array("storno", $error)) {
							array_push ( $error , "storno");
						}
						$error=implode("|", $error);
						$storno->order_error=$error;
						$storno->save();
					}
						
					$transaction->commit();
					Yii::app()->user->setFlash('3success','Wyszukiwanie potencjalnych "storn" zakońcone powodzeniem.');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('3error','Nie udało się wyszukiwanie potencjalnych "storn"');
				}
			}
			# przeładowanie strony wgrywania (strona wykryje potencjalne błędy (setFlash) i wyświetli je
			$this->refresh();
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
		$this->layout='//layouts/orderAdmin';
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
		if (isset($_GET["act"]) && isset($_POST["select"]) && $_GET["act"] == "set" ) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($checked);
				$Order->checked=1;					
				$Order->save();
			}
		} else if (isset($_GET["act"]) && isset($_POST["select"]) && $_GET["act"] == "unset" ) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($checked);
				$Order->checked=0;
				$Order->save();
			}
		} else if (isset($_GET["act"]) && $_GET["act"] == "reset" ) {
			$updated=Order::model()->updateAll(array('checked'=>0));
			echo "Skasowano zaznaczenie dla $updated pozycji.";
		} else if (isset($_GET["act"]) && $_GET["act"] == "read" ) {
			$Orders=Order::model()->findAllByAttributes(array('checked'=>1));
			foreach ($Orders as $order) {
				echo "$order->order_id,";
			}
		} else {
			print_r($_REQUEST);
		}
	}
	
	public function actionPrepared()
	{
		if (isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($checked);
				if ($Order->textile_prepared==0) {
					$Order->textile_prepared=1;
				} else {
					$Order->textile_prepared=0;
				}
				$Order->save();
			}
		} else {
			print_r($_REQUEST);
		}
	}
	
	public function actionManufactured()
	{	
		if (isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($checked);
				if ($Order->article_manufactured==0) {
					$Order->article_manufactured=$Order->article_amount * $Order->articleArticle->article_colli;
				} else {
					$Order->article_manufactured=0;
				}
				$Order->save();
			}
		} else {
			print_r($_REQUEST);
		}
	}

	public function actionCanceled()
	{
		if (isset($_POST["select"])) {
			foreach ($_POST["select"] as $id => $checked) {
				$Order=$this->loadModel($checked);
				if ($Order->article_canceled==0) {
					$Order->article_canceled=1;
				} else {
					$Order->article_canceled=0;
				}
				$Order->save();
			}
		} else {
			print_r($_REQUEST);
		}
	}
	
	public function actionSummary()
	{
		if (isset($_POST["summary"]) && isset($_POST["select"])) {
			#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
			#Pozycje na potrzeby faktury
			$Orders1=Order::model()->findAllByPk($pks, array(
				'select'=>array(
					'articleArticle.model_name as articleArticle_model_name',
					'articleArticle.model_type as articleArticle_model_type',
					new CDbExpression('IFNULL(t.textilpair_price_group, textile1Textile.textile_price_group) as textilpair_price_group'),
					new CDbExpression('SUM(t.article_amount) as article_amount'),
				),
				'with'=>array('articleArticle', 'textile1Textile'),
				'together'=>true,
				'group'=>'articleArticle.model_name, articleArticle.model_type, IFNULL(t.textilpair_price_group, textile1Textile.textile_price_group)',
				'order'=>'articleArticle.article_number ASC, textilpair_price_group ASC',
			));
			
			#Numery zamówień na potrzeby faktury
			$Orders2=Order::model()->findAllByPk($pks, array(
				'select'=>'DISTINCT order_number',
				'order'=>'order_number ASC',
			));
			
			#Rozkład tygodniowy poszczególnych modeli
			$Orders3=Order::model()->findAllByPk($pks, array(
				'select'=>array(
					'articleArticle.model_name as articleArticle_model_name',
					'articleArticle.model_type as articleArticle_model_type',
					't.order_term',
					new CDbExpression('SUM(t.article_amount) as article_amount'),
				),
				'with'=>array('articleArticle'),
				'together'=>true,
				'group'=>'articleArticle.model_name, articleArticle.model_type, t.order_term',
				'order'=>'t.order_term ASC, articleArticle.article_number ASC',
			));
			
			$this->render('summary',array(
					'Orders1'=>$Orders1, 
					'Orders2'=>$Orders2,
					'Orders3'=>$Orders3,
			));
		}
	}
	
	public function actionTextileSummary()
	{
		if (isset($_POST["textile_summary"]) && isset($_POST["select"])) {
			#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
				
			$criteria=new CDbCriteria;
			$criteria->select=array(
				'supplier_name',
				'textile_number',
				//new CDbExpression('GROUP_CONCAT(CONCAT(" * ", textile_name) SEPARATOR "<BR>\n") as textile_name'),
				new CDbExpression('MAX(textile_name) as textile_name'),
				new CDbExpression('SUM(textiles_selected) as textiles_selected'),
				'textile1_warehouse',
				'textiles_ordered',
				new CDbExpression('IF((SUM(textiles_selected) - textile1_warehouse -  textiles_ordered)>0, SUM(textiles_selected) - textile1_warehouse -  textiles_ordered, NULL) as textile_yet_need'),
				new CDbExpression('IF((SUM(textiles_selected) - textile1_warehouse -  textiles_ordered)<0, (SUM(textiles_selected) - textile1_warehouse -  textiles_ordered) * -1, NULL) as order1_id'),
				new CDBExpression('CONCAT(IFNULL(GROUP_CONCAT(order1_id),""),IF(GROUP_CONCAT(order1_id),",","")) as order1_number'),
				new CDBExpression('CONCAT(IFNULL(GROUP_CONCAT(order2_id),""),IF(GROUP_CONCAT(order2_id),",","")) as order2_number')
			);
			$criteria->addInCondition('order1_id',$pks, 'AND');
			$criteria->addInCondition('order2_id',$pks, 'OR');
			$criteria->group='supplier_name, textile_number, textile1_warehouse, textiles_ordered';
			$criteria->order='supplier_name ASC, textile_number ASC';
			#wyszukiwanie
			$rapTextile=RapTextile2::model()->findAll($criteria);
			
			#Budujemy model na potrzeby formularza dodającego zakup (zamówienie materiałów)
			foreach ($rapTextile as $key => $textile) {
				#tworzymy tablice modeli typu Shopping - tutaj będziemy zbierać dane, które zostaną zpaisane
				$shopping[$key]=new Shopping;
				$shopping[$key]->textile_textile_id=Textile::model()->find(array(
					'condition'=>'textile_number = :textile_number',
					'params'=>array(':textile_number'=>$textile->textile_number),
					'order'=>'pattern DESC, textile_name ASC',
					'limit'=>1
						
				))->textile_id;
				if($textile->textile_yet_need == null) {
					$shopping[$key]->article_calculated_amount=0;
				} else {
					$shopping[$key]->article_calculated_amount=$textile->textile_yet_need;
				}
				$shopping[$key]->order1_ids=$textile->order1_number;
				$shopping[$key]->order2_ids=$textile->order2_number;
			}
			
			
			$this->render('textile_summary',array(
					'rapTextile'=>$rapTextile,
					'shopping'=>$shopping
			));
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
					$order->article_manufactured+=$values["coli"];
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
				
				#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
				$pks=array();
				foreach ($_POST["select"] as $id => $checked) {
					array_push($pks, $checked);
				}
				#Kryteria wyszukiwania
				$criteria=new CDbCriteria;
				$criteria->with=array('articleArticle');
				$criteria->order='t.order_term ASC, articleArticle.article_number ASC';
				$Orders=Order::model()->findAllByPk($pks, $criteria);
				
				#Pętla po posortowanych zamówieniach i dodawanie etykiet na wydruk
				foreach ($Orders as $id => $Order) {
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
				$pdf->SetTitle("Lista załadunkowa");
				$pdf->SetDisplayMode("fullpage","continuous");
				
				$configuration=Configuration::model();
				$verladeliste_tour=$configuration->findByAttributes(array('name'=>'verladeliste_tour'))->value;
				$pdf->verladeliste_tour=str_replace(".", "", $verladeliste_tour);
				$pdf->ladedatum=$configuration->findByAttributes(array('name'=>'ladedatum'))->value;
					
				$pdf->AddPage();
				
				$pdf->DrawHead();
				$i=0;
				$articleAmountSum=0;
				$articleColiSum=0;
				
				#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
				$pks=array();
				foreach ($_POST["select"] as $id => $checked) {
					array_push($pks, $checked);
				}
				#Kryteria wyszukiwania
				$criteria=new CDbCriteria;
				$criteria->with=array('articleArticle');
				$criteria->order='articleArticle.article_number ASC, order_id ASC';
				$Orders=Order::model()->findAllByPk($pks, $criteria);
				
				#Pętla po posortowanych zamówieniach i dodawanie etykiet na wydruk
				foreach ($Orders as $id => $Order) {
					$pdf->orderNumber=$Order->order_number;
					$pdf->modelName=$Order->articleArticle->model_name;
					$pdf->modelType=$Order->articleArticle->model_type;
					$pdf->textileNumber="";
					preg_match('/([A-Z].*[0-9])/i',$Order->buyerBuyer->buyer_zip_code,$matches);
					isset($matches[1])? $pdf->buyerZipCode=$matches[1] : $pdf->buyerZipCode=$Order->buyerBuyer->buyer_zip_code;
					//jeżeli nie jest wyprodukowana całość (liczone w coli), to umieszczaj tylko część na ladeliste
					if ($Order->article_manufactured > 0 && $Order->article_manufactured < ($Order->article_amount * $Order->articleArticle->article_colli)) {
						$pdf->articleAmount=($Order->article_amount * $Order->article_manufactured) / ($Order->article_amount * $Order->articleArticle->article_colli);
						$pdf->articleColi=$Order->article_manufactured;
					} else {
						$pdf->articleAmount=$Order->article_amount;
						$pdf->articleColi=$Order->articleArticle->article_colli * $pdf->articleAmount;
					}
					$articleAmountSum=$articleAmountSum+$pdf->articleAmount;
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

					#Oznacz jako wywiezione, lub ewentualnie cofnij wywóz
					if ($pdf->verladeliste_tour == "null") {
						$Order->article_exported=null;
					} else {
						$Order->article_exported=$pdf->verladeliste_tour . " (" . date('mdhis') . ")";
					}
					$Order->save();
				
				}
				$pdf->articleAmount=$articleAmountSum;
				$pdf->articleColi=$articleColiSum;
				$pdf->DrawFooter();
				
				$pdf->Close();
				
				#Drukujemy - w sensie tworzymy plik PDF
				$filename="Ladeliste " .  str_replace("/", "-", $pdf->verladeliste_tour) . ".pdf";
				#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
				$pdf->Output($filename, "I");
				
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
				$old_order_term=0;
				
				#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
				$pks=array();
				foreach ($_POST["select"] as $id => $checked) {
					array_push($pks, $checked);
				}
				#Kryteria wyszukiwania
				$criteria=new CDbCriteria;
				$criteria->with=array('articleArticle');
				$criteria->order='t.order_term ASC, articleArticle.article_number ASC';
				$Orders=Order::model()->findAllByPk($pks, $criteria);
				
				#Pętla po posortowanych zamówieniach i dodawanie etykiet na wydruk
				foreach ($Orders as $id => $Order) {
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
							
							#Nowa strona w przypadku rozpoczęcia etykiet z nowego tygodnia
							$order_term=str_replace("/","",$Order->order_term);
							$order_term=str_replace(date('Y'),"",$order_term);
							if ($old_order_term != 0 && $order_term != $old_order_term && $quarter != 1){
								$quarter=1;
								$pdf->AddPage();
								$pdf->DrawLine();
							}
							$old_order_term=$order_term;
							
							
							#Zebranie danych
							
							$pdf->order_term=$order_term;
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
	
	public function actionPrintPlan()
	{
		# w przypadku tworzenia planu (otrzymano nr tyg w GET), zapisz jego numer do bazy; wywoływane przez Ajax
		if (isset($_GET["week_number"])) {
			if (isset($_POST["select"])) {
				$pks=array();
				foreach ($_POST["select"] as $id => $checked) {
					array_push($pks, $checked);
				}
				
				# zapis do bazy
				if ($_GET["week_number"] == "null") {
					Order::model()->updateByPk($pks, array('article_planed'=>null));
				} else if ($_GET["week_number"] == "/2015"){
					throw new CHttpException(405,'Nie podanu numeru tygodnia.');
				} else {
					Order::model()->updateByPk($pks, array('article_planed'=>$_GET["week_number"] . " " . date('mdhis')));
					return;
				}
				
			} else {
				throw new CHttpException(405,'Prawdopodobnie nie zostały zaznaczone żadne zamówienia.');
			}
		}
		
		# ustalanie danych oraz ich sortowania
		$criteria=new CDbCriteria;
		$criteria->with=array('articleArticle', 'legLeg', 'textile1Textile', 'textile2Textile', 'shopping1Shopping', 'shopping2Shopping');
		
		if ($_GET["act"] == "print_orders_for_cutting_department") {
			$criteria->order='order_term ASC, order_number ASC, articleArticle.article_number ASC';
		} else {
			$criteria->order='-article_planed DESC, order_term ASC, order_number ASC, articleArticle.article_number ASC';
		}
		
		# kryteria wyszukiwania wśród zaznaczonych
		if (isset($_POST["select"])) {
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
			$orders=Order::model()->findAllByPk($pks, $criteria);
			$type=" (Wybrane)";
		# kryteria wyszukiwania wśród wszystkich uwzględnianych (SQL where)
		} else {
			if ($_GET["act"] == "print_plan") {
				$criteria->condition=('article_exported is :article_exported AND article_canceled = :article_canceled AND article_planed is not :articel_planed');
				$criteria->params=array(':article_exported'=>null, ':article_canceled'=>0, ':articel_planed'=>null);
			} else {
				$criteria->condition=('article_exported is :article_exported AND article_canceled = :article_canceled');
				$criteria->params=array(':article_exported'=>null, ':article_canceled'=>0);
			}
			$orders=Order::model()->findAll($criteria);
			$type=" (Wszystkie)";
		}
		
		
		$plan=new PrintPlan();
		$plan->orders=$orders;
		$plan->version=$_GET["act"];
		$plan->type=$type;
		$plan->TcpdfInitiate();
		$plan->DataInitiate();
		$plan->DrawPages();
	}
	
	public function actionPrintOrdersWithPrice()
	{
		# ustalanie danych oraz ich sortowania
		$criteria=new CDbCriteria;
		$criteria->with=array('articleArticle', 'legLeg', 'textile1Textile', 'textile2Textile', 'shopping1Shopping', 'shopping2Shopping');
		$criteria->order='-article_planed DESC, order_term ASC, order_number ASC, articleArticle.article_number ASC';
		
		# kryteria wyszukiwania wśród zaznaczonych
		if (isset($_POST["select"])) {
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
			$orders=Order::model()->findAllByPk($pks, $criteria);
			$type=" (Wybrane)";
		# kryteria wyszukiwania wśród wszystkich uwzględnianych (SQL where)
		} else {
			$criteria->condition=('article_exported is :article_exported AND article_canceled = :article_canceled');
			$criteria->params=array(':article_exported'=>null, 'article_canceled'=>0);
			$orders=Order::model()->findAll($criteria);
			$type=" (Wszystkie)";
		}
		
		$plan=new PrintPlan();
		$plan->orders=$orders;
		$plan->version='with_price';
		$plan->type=$type;
		$plan->TcpdfInitiate();
		$plan->DataInitiate();
		$plan->DrawPages();
	}
	
	public function actionSearchTextiles()
	{
		# ustalanie danych wejściowych (przeszukiwanych), wraz z wstępnym sortowaniem
		if (isset($_POST["select"])) {
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
				
			$criteria=new CDbCriteria;
			$criteria->with=array('articleArticle', 'legLeg', 'textile1Textile', 'textile2Textile');
			$criteria->order='order_term ASC, order_number ASC, articleArticle.article_number ASC';
			$orders=Order::model()->findAllByPk($pks, $criteria);
		} else {
			$criteria=new CDbCriteria;
			$criteria->with=array('articleArticle', 'legLeg', 'textile1Textile', 'textile2Textile');
			$criteria->condition=('article_exported is :article_exported AND article_canceled = :article_canceled');
			$criteria->params=array(':article_exported'=>null, 'article_canceled'=>0);
			$criteria->order='order_term ASC, order_number ASC, articleArticle.article_number ASC';
			$orders=Order::model()->findAll($criteria);
		}
		
		# ustalenie materiałów do ponownego wykożystania
		$ordersForReuse=ForReuse::model()->findAll();
		
		#####
		# Wyszukanie dopasowań
		#####
		$ordersInfo=array();
		$ordersForReuseInfo=array();
		foreach ($orders as $order) {
			//$order->order_id;
			//$order->order_number;
			//$order->articleArticle->article_number;
			$textile1Number=isset($order->textile1Textile->textile_number) ? $order->textile1Textile->textile_number : null;
			$textile2Number=isset($order->textile2Textile->textile_number) ? $order->textile2Textile->textile_number : null;
			
			foreach ($ordersForReuse as $orderForReuse) {
				# dostępne pola
				//$orderForReuse->order_number;
				//$orderForReuse->article_number;
				$textile1ForReuseNumber=isset($orderForReuse->textile1_number) ? $orderForReuse->textile1_number : null;
				$textile2ForReuseNumber=isset($orderForReuse->textile2_number) ? $orderForReuse->textile2_number : null;
				
				# inicjalizujemy tablice na informacje
				if (empty($ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"])) $ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"]=array();
				if (empty($ordersForReuseInfo[$orderForReuse->for_reuse_id]["first"])) $ordersForReuseInfo[$orderForReuse->for_reuse_id]["first"]=array();
				if (empty($ordersForReuseInfo[$orderForReuse->for_reuse_id]["second"])) $ordersForReuseInfo[$orderForReuse->for_reuse_id]["second"]=array();
				
				# wyszukujemy dopasowania do obydwuch materiałów
				if ($order->articleArticle->article_number == $orderForReuse->article_number &&
					$textile1Number == $textile1ForReuseNumber && $textile2Number == $textile2ForReuseNumber) 
				{
					# w $orderForReuseInfo[] zapisz id $order wszystkich dopasowanych zamówień
					array_push($ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"], $order->order_number."(".$textile1Number." ".$textile2Number.")");
				}
				
				# wyszukujemy dopasowania do pierwszego materiału
				if ($order->articleArticle->article_number == $orderForReuse->article_number &&
					$textile1Number == $textile1ForReuseNumber) 
				{
					# w $orderForReuseInfo[] zapisz id $order wszystkich dopasowanych zamówień
					array_push($ordersForReuseInfo[$orderForReuse->for_reuse_id]["first"], $order->order_number."(".$textile1Number." ".$textile2Number.")");
				}
				
				# wyszukujemy dopasowania do drugiego materiału
				if ($order->articleArticle->article_number == $orderForReuse->article_number &&
				$textile2Number != null && $textile2ForReuseNumber != null && $textile2Number == $textile2ForReuseNumber)
				{
					# w $orderForReuseInfo[] zapisz id $order wszystkich dopasowanych zamówień
					array_push($ordersForReuseInfo[$orderForReuse->for_reuse_id]["second"], $order->order_number."(".$textile1Number." ".$textile2Number.")");
				}
				
			}
		}
		
		$pdf=new SearchTextiles('P', 'mm', 'A4', true, 'UTF-8');
		$pdf->Initiate();
		
		
		#####
		# Pokaż najlepsze dopasowania na osobnej liście
		#####
		foreach ($ordersForReuse as $orderForReuse) {
			# pobieramy dodatkowe informacje o artykule
			$article=Article::model()->find(array(
				'select'=>'model_name, model_type',
				'condition'=>'article_number=:article_number',
				'params'=>array(':article_number'=>$orderForReuse->article_number),
				'limit'=>1
			));
			
			# dostępne pola
			//$orderForReuse->order_number;
			//$orderForReuse->article_number;
			$textile1ForReuseNumber=isset($orderForReuse->textile1_number) ? $orderForReuse->textile1_number : null;
			$textile2ForReuseNumber=isset($orderForReuse->textile2_number) ? $orderForReuse->textile2_number : null;
			$modelName=$article->model_name;
			$modelType=$article->model_type;
			
			# zamieniamy wartości w tablicy na ładny ciąg typu string
			$both=implode($ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"],"\n");
			# przed zamianą usówamy elementy które występiły w tablicy/zmiennej "both"
			$first=implode(array_diff($ordersForReuseInfo[$orderForReuse->for_reuse_id]["first"],$ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"]),"\n");
			$second=implode(array_diff($ordersForReuseInfo[$orderForReuse->for_reuse_id]["second"],$ordersForReuseInfo[$orderForReuse->for_reuse_id]["both"]),"\n");
			
			$pdf->Draw(array(
				$orderForReuse->article_number . "\n$modelName\n$modelType",
				$orderForReuse->order_number."\n(".$textile1ForReuseNumber." ".$textile2ForReuseNumber.")",
				$both,
				$first,
				$second
			));
		}
		
		#Drukujemy - w sensie tworzymy plik PDF
		#I - w przeglądarce, D - download, I - zapis na serwerze, S - ?
		$pdf->Output("Wolne wykroje " . date('Y-m-d') . ".pdf", "I");
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
