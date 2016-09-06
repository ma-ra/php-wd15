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
				'users'=>array('asia', 'gosia', 'mara', 'mariola', 'michalina', 'pawel'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('create', 'delete', 'upload', 'printOrdersWithPrice', 'searchTextiles'),
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
		# tablica z poprawnymi nazwami, np dla modelu SO7100 - w wczytywanym pliku nazwy często są ucięte
		//TO DO: uzupełnic listę bo doszły nowe modele
		$correctTypeList=array(
			71040110 => '10 Hockerbank',
			71040115 => '15 Hockerbank',
			71055010 => '10 LC - 3 inkl. BK',
			71055015 => '15 LC - 3 inkl. BK',
			71055110 => '10 LC - 3Q inkl. BK',
			71055115 => '15 LC - 3Q inkl. BK',
			71055210 => '10 LCALFu - 3ALFu inkl. BK',
			71055215 => '15 LCALFu - 3ALFu inkl. BK',
			71055310 => '10 LCALFu - 3QALFu inkl. BK',
			71055315 => '15 LCALFu - 3QALFu inkl. BK',
			71055410 => '10 LC - 3 / SV inkl. BK',
			71055415 => '15 LC - 3 / SV inkl. BK',
			71055510 => '10 LC - 3Q / SV inkl. BK',
			71055515 => '15 LC - 3Q / SV inkl. BK',
			71055610 => '10 LCALFu - 3ALFu / SV inkl. BK',
			71055615 => '15 LCALFu - 3ALFu / SV inkl. BK',
			71055710 => '10 LCALFu - 3QALFu / SV inkl. BK',
			71055715 => '15 LCALFu - 3QALFu / SV inkl. BK',
			71055810 => '10 LCRFu - 3RFU inkl. BK',
			71055815 => '15 LCRFu - 3RFU inkl. BK',
			71055910 => '10 LCRFu - 3QRFu inkl. BK',
			71055915 => '15 LCRFu - 3QRFu inkl. BK',
			71056010 => '10 LCALFuRFu - 3ALFuRFu inkl. BK',
			71056015 => '15 LCALFuRFu - 3ALFuRFu inkl. BK',
			71056110 => '10 LCALFuRFu - 3QALFuRFu inkl. BK',
			71056115 => '15 LCALFuRFu - 3QALFuRFu inkl. BK',
			71056210 => '10 LCRFu - 3RFu / SV inkl. BK',
			71056215 => '15 LCRFu - 3RFu / SV inkl. BK',
			71056310 => '10 LCRFu - 3QRFu / SV inkl. BK',
			71056315 => '15 LCRFu - 3QRFu / SV inkl. BK',
			71056410 => '10 LCALFuRFu - 3ALFuRfu / SV inkl. BK',
			71056415 => '15 LCALFuRFu - 3ALFuRfu / SV inkl. BK',
			71056510 => '10 LCALFuRFu - 3QALFuRfu / SV inkl. BK',
			71056515 => '15 LCALFuRFu - 3QALFuRfu / SV inkl. BK',
			71056610 => '10 3 - LC inkl. BK',
			71056615 => '15 3 - LC inkl. BK',
			71056710 => '10 3Q - LC inkl. BK',
			71056715 => '15 3Q - LC inkl. BK',
			71056810 => '10 3ALFu - LCALFu inkl. BK',
			71056815 => '15 3ALFu - LCALFu inkl. BK',
			71056910 => '10 3QALFu - LCALFu inkl. BK',
			71056915 => '15 3QALFu - LCALFu inkl. BK',
			71057010 => '10 3 / SV - LC inkl. BK',
			71057015 => '15 3 / SV - LC inkl. BK',
			71057110 => '10 3Q / SV - LC inkl. BK',
			71057115 => '15 3Q / SV - LC inkl. BK',
			71057210 => '10 3ALFu / SV - LCALFu inkl. BK',
			71057215 => '15 3ALFu / SV - LCALFu inkl. BK',
			71057310 => '10 3QALFu / SV - LCALFu inkl. BK',
			71057315 => '15 3QALFu / SV - LCALFu inkl. BK',
			71057410 => '10 3RFu - LCRFu inkl. BK',
			71057415 => '15 3RFu - LCRFu inkl. BK',
			71057510 => '10 3QRFu - LCRFU inkl. BK',
			71057515 => '15 3QRFu - LCRFU inkl. BK',
			71057610 => '10 3ALFuRFu - LCALFuRFu inkl. BK',
			71057615 => '15 3ALFuRFu - LCALFuRFu inkl. BK',
			71057710 => '10 3QALFuRFu - LCALFuRFu inkl. BK',
			71057715 => '15 3QALFuRFu - LCALFuRFu inkl. BK',
			71057810 => '10 3RFu / SV - LCRFu inkl. BK',
			71057815 => '15 3RFu / SV - LCRFu inkl. BK',
			71057910 => '10 3QRFu / SV - LCRFU inkl. BK',
			71057915 => '15 3QRFu / SV - LCRFU inkl. BK',
			71058010 => '10 3ALFuRFu / SV - LCALFuRFu inkl. BK',
			71058015 => '15 3ALFuRFu / SV - LCALFuRFu inkl. BK',
			71058110 => '10 3QALFuRFu / SV - LCALFuRFu inkl. BK',
			71058115 => '15 3QALFuRFu / SV - LCALFuRFu inkl. BK im Longchair',
			71060010 => '10 LC - 3EL - Ottomane',
			71060015 => '15 LC - 3EL - Ottomane',
			71060110 => '10 Ottomane - 3EL - LC',
			71060115 => '15 Ottomane - 3EL - LC',
			71060210 => '10 LC - 3EL / SV - Ottomane / SV',
			71060215 => '15 LC - 3EL / SV - Ottomane / SV',
			71060310 => '10 LC - 3QEL / SV - Ottomane / SV',
			71060315 => '15 LC - 3QEL / SV - Ottomane / SV',
			71060410 => '10 LCALFu - 3EL / SV - Ottomane / SV',
			71060415 => '15 LCALFu - 3EL / SV - Ottomane / SV',
			71060510 => '10 LCALFu - 3QEL / SV - Ottomane / SV',
			71060515 => '15 LCALFu - 3QEL / SV - Ottomane / SV',
			71060610 => '10 LCRFu - 3ELRFu - OttomaneRFu',
			71060615 => '15 LCRFu - 3ELRFu - OttomaneRFu',
			71060710 => '10 LCRFu - 3QELRFu - OttomaneRFu',
			71060715 => '15 LCRFu - 3QELRFu - OttomaneRFu',
			71060810 => '10 LCALFuRFu - 3ELRFu - OttomaneRFu',
			71060815 => '15 LCALFuRFu - 3ELRFu - OttomaneRFu',
			71060910 => '10 LCALFuRFu - 3QELRFu - OttomaneRFu',
			71060915 => '15 LCALFuRFu - 3QELRFu - OttomaneRFu',
			71062610 => '10 LCRFu - 3ELRFu / SV - OttomaneRFu / SV',
			71062615 => '15 LCRFu - 3ELRFu / SV - OttomaneRFu / SV',
			71062710 => '10 LCRFu - 3QELRFu / SV - OttomaneRFu / SV',
			71062715 => '15 LCRFu - 3QELRFu / SV - OttomaneRFu / SV',
			71062810 => '10 LCALFuRFu - 3ELRFu / SV - OttomaneRFu / SV',
			71062815 => '15 LCALFuRFu - 3ELRFu / SV - OttomaneRFu / SV',
			71062910 => '10 LCALFuRFu - 3QELRFu / SV - OttomaneRFu / SV',
			71062915 => '15 LCALFuRFu - 3QELRFu / SV - OttomaneRFu / SV',
			71063010 => '10 LCALFu - 3EL - Ottomane',
			71063015 => '15 LCALFU - 3EL - Ottomane',
			71063110 => '10 Ottomane - 3EL - LCALFu',
			71063115 => '15 Ottomane - 3EL - LCALFu',
			71063210 => '10 Ottomane / SV - 3EL / SV - LC',
			71063215 => '15 Ottomane / SV - 3EL / SV - LC',
			71063310 => '10 Ottomane / SV - 3QEL / SV - LC',
			71063315 => '15 Ottomane / SV - 3QEL / SV - LC',
			71063410 => '10 Ottomane / SV - 3EL / SV - LCALFu',
			71063415 => '15 Ottomane / SV - 3EL / SV - LCALFu',
			71063510 => '10 Ottomane / SV - 3QEL / SV - LCALFu',
			71063515 => '15 Ottomane / SV - 3QEL / SV - LCALFu',
			71063610 => '10 OttomaneRFu - 3ELRFu - LCRFu',
			71063615 => '15 OttomaneRFu - 3ELRFu - LCRFu',
			71063710 => '10 OttomaneRFu - 3QELRFu - LCRFu',
			71063715 => '15 OttomaneRFu - 3QELRFu - LCRFu',
			71063810 => '10 OttomaneRFu - 3ELRFu - LCALFuRFu',
			71063815 => '15 OttomaneRFu - 3ELRFu - LCALFuRFu',
			71063910 => '10 OttomaneRFu - 3QELRFu - LCALFuRFu',
			71063915 => '15 OttomaneRFu - 3QELRFu - LCALFuRFu',
			71064010 => '10 LCALFu - 3QEL - Ottomane',
			71064015 => '15 LCALFu - 3QEL - Ottomane',
			71064110 => '10 Ottomane - 3QEL - LCALFu',
			71064115 => '15 Ottomane - 3QEL - LCALFu',
			71064210 => '10 OttomaneRFu / SV - 3ELRFu / SV - LCRFu',
			71064215 => '15 OttomaneRFu / SV - 3ELRFu / SV - LCRFu',
			71064310 => '10 OttomaneRFu / SV - 3QELRFu / SV - LCRFu',
			71064315 => '15 OttomaneRFu / SV - 3QELRFu / SV - LCRFu',
			71064410 => '10 OttomaneRFu / SV - 3ELRFu / SV - LCALFuRFu',
			71064415 => '15 OttomaneRFu / SV - 3ELRFu / SV - LCALFuRFu',
			71064510 => '10 OttomaneRFu / SV - 3QELRFu / SV - LCALFuRFu',
			71064515 => '15 OttomaneRFu / SV - 3QELRFu / SV - LCALFuRFu',
			71064610 => '10 LC - 3EL - Ottomane inkl. Box',
			71064615 => '15 LC - 3EL - Ottomane inkl. Box',
			71064710 => '10 Ottomane - 3EL - LC inkl. Box',
			71064715 => '15 Ottomane - 3EL - LC inkl. Box',
			71064810 => '10 LC - 3QEL - Ottomane inkl. Box',
			71064815 => '15 LC - 3QEL - Ottomane inkl. Box',
			71064910 => '10 Ottomane - 3QEL - LC inkl. Box',
			71064915 => '15 Ottomane - 3QEL - LC inkl. Box',
			71065010 => '10 LC - 3QEL - Ottomane',
			71065015 => '15 LC - 3QEL - Ottomane',
			71065110 => '10 Ottomane - 3QEL - LC',
			71065115 => '15 Ottomane - 3QEL - LC',
			71065210 => '10 LCALFu - 3EL - Ottomane inkl. Box',
			71065215 => '15 LCALFu - 3EL - Ottomane inkl. Box',
			71065310 => '10 LCALFu - 3QEL - Ottomane inkl. Box',
			71065315 => '15 LCALFu - 3QEL - Ottomane inkl. Box',
			71065410 => '10 LC - 3EL / SV - Ottomane / SV inkl. Box',
			71065415 => '15 LC - 3EL / SV - Ottomane / SV inkl. Box',
			71065510 => '10 LC - 3QEL / SV - Ottomane / SV inkl. Box',
			71065515 => '15 LC - 3QEL / SV - Ottomane / SV inkl. Box',
			71065610 => '10 LCALFu - 3EL / SV - Ottomane / SV inkl. Box',
			71065615 => '15 LCALFu - 3EL / SV - Ottomane / SV inkl. Box',
			71065710 => '10 LCALFu - 3QEL / SV - Ottomane / SV inkl. Box',
			71065715 => '15 LCALFu - 3QEL / SV - Ottomane / SV inkl. Box',
			71065810 => '10 LCRFu - 3ELRFu - OttomaneRFu inkl. Box',
			71065815 => '15 LCRFu - 3ELRFu - OttomaneRFu inkl. Box',
			71065910 => '10 LCRFu - 3QELRFu - OttomaneRFu inkl. Box',
			71065915 => '15 LCRFu - 3QELRFu - OttomaneRFu inkl. Box',
			71066010 => '10 LCALFuRFu - 3ELRFu - OttomaneRFu inkl. Box',
			71066015 => '15 LCALFuRFu - 3ELRFu - OttomaneRFu inkl. Box',
			71066110 => '10 LCALFuRFu - 3QELRFu - OttomaneRFu inkl. Box',
			71066115 => '15 LCALFuRFu - 3QELRFu - OttomaneRFu inkl. Box',
			71066210 => '10 LCRFu - 3ELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066215 => '15 LCRFu - 3ELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066310 => '10 LCRFu - 3QELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066315 => '15 LCRFu - 3QELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066410 => '10 LCALFuRFu - 3QELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066415 => '15 LCALFuRFu - 3QELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066510 => '10 LCALFuRFu - 3ELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066515 => '15 LCALFuRFu - 3ELRFu / SV - OttomaneRFu / SV inkl. Box',
			71066610 => '10 Ottomane - 3EL - LCALFu inkl. Box',
			71066615 => '15 Ottomane - 3EL - LCALFu inkl. Box',
			71066710 => '10 Ottomane - 3QEL - LCALFu inkl. Box',
			71066715 => '15 Ottomane - 3QEL - LCALFu inkl. Box',
			71066810 => '10 Ottomane / SV - 3EL / SV - LC inkl. Box',
			71066815 => '15 Ottomane / SV - 3EL / SV - LC inkl. Box',
			71066910 => '10 Ottomane / SV - 3QEL / SV - LC inkl. Box',
			71066915 => '15 Ottomane / SV - 3QEL / SV - LC inkl. Box',
			71067010 => '10 Ottomane / SV - 3EL / SV - LCALFu inkl. Box',
			71067015 => '15 Ottomane / SV - 3EL / SV - LCALFu inkl. Box',
			71067110 => '10 Ottomane / SV - 3QEL / SV - LCALFu inkl. Box',
			71067115 => '15 Ottomane / SV - 3QEL / SV - LCALFu inkl. Box',
			71067210 => '10 OttomaneRFu - 3ELRFu - LCRFu inkl. Box',
			71067215 => '15 OttomaneRFu - 3ELRFu - LCRFu inkl. Box',
			71067310 => '10 OttomaneRFu - 3QELRFu - LCRFu inkl. Box',
			71067315 => '15 OttomaneRFu - 3QELRFu - LCRFu inkl. Box',
			71067410 => '10 OttomaneRFu - 3ELRFu - LCALFuRFu inkl. Box',
			71067415 => '15 OttomaneRFu - 3ELRFu - LCALFuRFu inkl. Box',
			71067510 => '10 OttomaneRFu - 3QELRFu - LCALFuRFu inkl. Box',
			71067515 => '15 OttomaneRFu - 3QELRFu - LCALFuRFu inkl. Box',
			71067610 => '10 OttomaneRFu / SV - 3ELRFu / SV - LCRFu inkl. Box',
			71067615 => '15 OttomaneRFu / SV - 3ELRFu / SV - LCRFuinkl. Box',
			71067710 => '10 OttomaneRFu / SV - 3QELRFu / SV - LCRFu inkl. Box',
			71067715 => '15 OttomaneRFu / SV - 3QELRFu / SV - LCRFuinkl. Box',
			71067810 => '10 OttomaneRFu / SV - 3ELRFu / SV - LCALFuRFu inkl. Box',
			71067815 => '15 OttomaneRFu / SV - 3ELRFu / SV - LCALFuRFu inkl. Box',
			71067910 => '10 OttomaneRFu / SV - 3QELRFu / SV - LCALFuRFu inkl. Box',
			71067915 => '15 OttomaneRFu / SV - 3QELRFu / SV - LCALFuRFu inkl. Box',
			71070210 => '10 3 - LC',
			71070215 => '15 3 - LC',
			71070310 => '10 LC - 3',
			71070315 => '15 LC - 3',
			71070410 => '10 3 - Ottomane',
			71070415 => '15 3 - Ottomane',
			71070510 => '10 Ottomane - 3',
			71070515 => '15 Ottomane - 3',
			71070610 => '10 3Q - LC',
			71070615 => '15 3Q - LC',
			71070710 => '10 LC - 3Q',
			71070715 => '15 LC - 3Q',
			71070810 => '10 3Q - Ottomane',
			71070815 => '15 3Q - Ottomane',
			71070910 => '10 Ottomane - 3Q',
			71070915 => '15 Ottomane - 3Q',
			71071210 => '10 3ALFu - Ottomane',
			71071215 => '15 3ALFu - Ottomane',
			71071310 => '10 Ottomane - 3ALFu',
			71071315 => '15 Ottomane - 3ALFu',
			71071410 => '10 3QALFu - Ottomane',
			71071415 => '15 3QALFu - Ottomane',
			71071510 => '10 Ottomane - 3QALFu',
			71071515 => '15 Ottomane - 3QALFu',
			71071610 => '10 3RFu - OttomaneRFu',
			71071615 => '15 3RFu - OttomaneRFu',
			71071710 => '10 OttomaneRFu - 3RFU',
			71071715 => '15 OttomaneRFu - 3RFU',
			71071810 => '10 3QRFu - OttomaneRFU',
			71071815 => '15 3QRFu - OttomaneRFU',
			71071910 => '10 OttomaneRFu - 3QRFu',
			71071915 => '15 OttomaneRFu - 3QRFu',
			71072010 => '10 3ALFuRFu - OttomaneRFu',
			71072015 => '15 3ALFuRFu - OttomaneRFu',
			71072110 => '10 OttomaneRFu - 3ALFuRFu',
			71072115 => '15 OttomaneRFu - 3ALFuRFu',
			71072210 => '10 3QALFuRFu - OttomaneRFu',
			71072215 => '15 3QALFuRFu - OttomaneRFu',
			71072310 => '10 OttomaneRFu - 3QALFuRFu',
			71072315 => '15 OttomaneRFu - 3QALFuRFu',
			71073210 => '10 LCALFu - 3ALFu',
			71073215 => '15 LCALFu - 3ALFu',
			71073310 => '10 LCALFu - 3QALFu',
			71073315 => '15 LCALFu - 3QALFu',
			71073410 => '10 3ALFu - LCALFu',
			71073415 => '15 3ALFu - LCALFu',
			71074610 => '10 OttomaneRFu / SV - 3ELRFu / SV - LCALFuRFu / SV',
			71074815 => '15 Ottomane / SV - 3 / SV',
			71074915 => '15 Ottomane / SV - 3Q / SV',
			71075010 => '10 Ottomane / SV - 3ALFu / SV',
			71075015 => '15 Ottomane / SV - 3ALFu / SV',
			71075115 => '15 Ottomane / SV - 3QALFu / SV',
			71075510 => '10 3 / SV - Ottomane / SV',
			71075515 => '15 3 / SV - Ottomane / SV',
			71075610 => '10 3Q / SV - Ottomane / SV',
			71075615 => '15 3Q / SV - Ottomane / SV',
			71075710 => '10 3ALFu / SV - Ottomane / SV',
			71075715 => '15 3ALFu / SV - Ottomane / SV',
			71075810 => '10 3QALFu / SV - Ottomane / SV',
			71075815 => '15 3QALFu / SV - Ottomane / SV',
			71075910 => '10 3RFu / SV - OttomaneRFu / SV',
			71075915 => '15 3RFu / SV - OttomaneRFu / SV',
			71076010 => '10 3QRFu / SV - OttomaneRFU / SV',
			71076015 => '15 3QRFu / SV - OttomaneRFU / SV',
			71076110 => '10 3ALFuRFu / SV - OttomaneRFu / SV',
			71076115 => '15 3ALFuRFu / SV - OttomaneRFu / SV',
			71076210 => '10 3QALFuRFu / SV - OttomaneRFu / SV',
			71076215 => '15 3QALFuRFu / SV - OttomaneRFu / SV',
			71076310 => '10 Ottomane / SV - 3 / SV',
			71076410 => '10 Ottomane / SV - 3Q / SV',
			71076510 => '10 Ottomane / SV - 3ALFu / SV',
			71076610 => '10 Ottomane / SV - 3QALFu / SV',
			71076615 => '15 Ottomane / SV - 3QALFu / SV',
			71076710 => '10 OttomaneRFu / SV - 3RFu / SV',
			71076715 => '15 OttomaneRFu / SV - 3RFu / SV',
			71076810 => '10 OttomaneRFu / SV - 3QRFu / SV',
			71076815 => '15 OttomaneRFu / SV - 3QRFu / SV',
			71076910 => '10 OttomaneRFu / SV - 3ALFuRfu / SV',
			71076915 => '15 OttomaneRFu / SV - 3ALFuRfu / SV',
			71077010 => '10 OttomaneRFu / SV - 3QALFuRfu / SV',
			71077015 => '15 OttomaneRFu / SV - 3QALFuRfu / SV',
			71077110 => '10 LC - 3 / SV',
			71077115 => '15 LC - 3 / SV',
			71077210 => '10 LC - 3Q / SV',
			71077215 => '15 LC - 3Q / SV',
			71077310 => '10 LCALFu - 3ALFu / SV',
			71077315 => '15 LCALFu - 3ALFu / SV',
			71077410 => '10 LCALFu - 3QALFu / SV',
			71077415 => '15 LCALFu - 3QALFu / SV',
			71077510 => '10 LCRFu - 3RFU',
			71077515 => '15 LCRFu - 3RFU',
			71077610 => '10 LCRFu - 3QRFu',
			71077615 => '15 LCRFu - 3QRFu',
			71077710 => '10 LCALFuRFu - 3ALFuRFu',
			71077715 => '15 LCALFuRFu - 3ALFuRFu',
			71077810 => '10 LCALFuRFu - 3QALFuRFu',
			71077815 => '15 LCALFuRFu - 3QALFuRFu',
			71077910 => '10 LCRFu - 3RFu / SV',
			71077915 => '15 LCRFu - 3RFu / SV',
			71078010 => '10 LCRFu - 3QRFu / SV',
			71078015 => '15 LCRFu - 3QRFu / SV',
			71078110 => '10 LCALFuRFu - 3ALFuRfu / SV',
			71078115 => '15 LCALFuRFu - 3ALFuRfu / SV',
			71078210 => '10 LCALFuRFu - 3QALFuRfu / SV',
			71078215 => '15 LCALFuRFu - 3QALFuRfu / SV',
			71078310 => '10 3QALFu - LCALFu',
			71078315 => '15 3QALFu - LCALFu',
			71078410 => '10 3 / SV - LC',
			71078415 => '15 3 / SV - LC',
			71078510 => '10 3Q / SV - LC',
			71078515 => '15 3Q / SV - LC',
			71078610 => '10 3ALFu / SV - LCALFu',
			71078615 => '15 3ALFu / SV - LCALFu',
			71078710 => '10 3QALFu / SV - LCALFu',
			71078715 => '15 3QALFu / SV - LCALFu',
			71078910 => '10 3RFu - LCRFu',
			71078915 => '15 3RFu - LCRFu',
			71079010 => '10 3QRFu - LCRFU',
			71079015 => '15 3QRFu - LCRFU',
			71079110 => '10 3ALFuRFu - LCALFuRFu',
			71079115 => '15 3ALFuRFu - LCALFuRFu',
			71079210 => '10 3QALFuRFu - LCALFuRFu',
			71079215 => '15 3QALFuRFu - LCALFuRFu',
			71079310 => '10 3RFu / SV - LCRFu',
			71079315 => '15 3RFu / SV - LCRFu',
			71079410 => '10 3QRFu / SV - LCRFU',
			71079415 => '15 3QRFu / SV - LCRFU',
			71079510 => '10 3ALFuRFu / SV - LCALFuRFu',
			71079515 => '15 3ALFuRFu / SV - LCALFuRFu',
			71079610 => '10 3QALFuRFu / SV - LCALFuRFu',
			71079615 => '15 3QALFuRFu / SV - LCALFuRFu',
			71097099 => 'Kissensatz 3-Otto / Otto-3',
			71098099 => 'Kissensatz 3-LC / LC-3',
			71099099 => 'Kissensatz LC-3-Ott / Ott-3-LC',
		);
		
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
					# komunikaty sa zapisywane do tablicy, gdzie 1success jest kluczem - stąd jedynka, aby kilka succes nie nałożyło się;
					# 1success po obcięciu pierwszej cyfry, jest również nazwą klasy css wpływającej na kolor powiadomienia
					Yii::app()->user->setFlash('1success','Poprawnie skasowane stare błędy typu: "exported".');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('1error','Nie udało się skasować błędów typu: "exported".');
				}
				
				# usuń dotychczasowe błędy typu: storno
				$storned=Order::model()->findAll(array(
					'condition'=>'order_error like :storno',
					'params'=>array(':storno'=>'%storno%'),
				));
				
				$transaction = Yii::app()->db->beginTransaction();
				try {
					foreach ($storned as $key => $order) {
						$error=explode("|", $order->order_error);
						if (in_array("storno", $error)) {
							$error = array_diff($error, array("storno"));
							$error=implode("|", $error);
							$order->order_error=$error;
							$order->save();
						}
					}
					
					$transaction->commit();
					# komunikaty sa zapisywane do tablicy, gdzie 1success jest kluczem - stąd jedynka, aby kilka succes nie nałożyło się;
					# 1success po obcięciu pierwszej cyfry, jest również nazwą klasy css wpływającej na kolor powiadomienia
					Yii::app()->user->setFlash('2success','Poprawnie skasowane stare błędy typu: "storno".');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('2error','Nie udało się skasować błędów typu: "storno".');
				}
				
				# usuń dotychczasowe błędy typu: bad_article
				$bad_article=Order::model()->findAll(array(
					'condition'=>'order_error like :bad_article',
					'params'=>array(':bad_article'=>'%bad_article%'),
				));
				
				$transaction = Yii::app()->db->beginTransaction();
				try {
					foreach ($bad_article as $key => $order) {
						$error=explode("|", $order->order_error);
						if (in_array("bad_article1", $error)) {
							$error = array_diff($error, array("bad_article1"));
						}
						if (in_array("bad_article2", $error)) {
							$error = array_diff($error, array("bad_article2"));
						}
						if (in_array("bad_article3", $error)) {
							$error = array_diff($error, array("bad_article3"));
						}
						$error=implode("|", $error);
						$order->order_error=$error;
						$order->save();
					}
					
					$transaction->commit();
					# komunikaty sa zapisywane do tablicy, gdzie 1success jest kluczem - stąd jedynka, aby kilka succes nie nałożyło się;
					# 1success po obcięciu pierwszej cyfry, jest również nazwą klasy css wpływającej na kolor powiadomienia
					Yii::app()->user->setFlash('3success','Poprawnie skasowane stare błędy typu: "bad_article".');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('3error','Nie udało się skasować błędów typu: "bad_article".');
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
							####
							# Rozpiska kolumn z zaczytywanego pliku (stara wersja)
							# $line[0] - Lieferant Nr.
							# $line[1] - Lieferant
							# $line[2] - Jahr
							# $line[3] - Best.Nr.
							# $line[4] - Best.Datum
							# $line[5] - Lieferanschrift - Name
							# $line[6] - Lieferanschrift - Name 2
							# $line[7] - Lieferanschrift - Strasse
							# $line[8] - Lieferanschrift - PLZ & Ort
							# $line[9] - Bestellnr./Kunde
							# $line[10] - Werbung
							# $line[11] - Art.Nr.
							# $line[12] - Modelltext
							# $line[13] - Ausführung
							# $line[14] - Füße
							# $line[15] - Stoff Nr.
							# $line[16] - Stoff Text 1
							# $line[17] - Stoff Text 2
							# $line[18] - EK Gruppe
							# $line[19] - Referenz
							# $line[20] - Kommission
							# $line[21] - Termintext
							# $line[22] - Termin KW
							# $line[23] - Preis
							# $line[24] - Rückstand
							# $line[25] - Betrag
							# $line[26] - Rabatt/Z. 1
							# $line[27] - Rabatt/Z. Text 1
							# $line[28] - Rabatt/Z. 2
							# $line[29] - Rabatt/Z. Text 2
							# $line[30] - Rabatt/Z. 3
							# $line[31] - Rabatt/Z. Text 3
							# $line[32] - Rabatt/Z. 4
							# $line[33] - Rabatt/Z. Text 4
							# $line[34] - Rabatt/Z. 5
							# $line[35] - Rabatt/Z. Text 5
							####
							
							####
							# Rozpiska kolumn z zaczytywanego pliku (nowa wersja)
							# $line[0] - Bestellnr.
							# $line[1] - Registrierungsdatum
							# $line[2] - Registriert bei
							# $line[3] - Bestellstatus
							# $line[4] - Produktionswoche
							# $line[5] - Lieferant Nummer
							# $line[6] - Lieferant Name
							# $line[7] - Kunde - Name
							# $line[8] - Kunde - Straße
							# $line[9] - Kunde - PLZ
							# $line[10] - Kunde - Stadt
							# $line[11] - Kundenauftragsnummer
							# $line[12] - Kunde - Email
							# $line[13] - Kunde - Telefonnummer
							# $line[14] - Kunde - Faxnummer
							# $line[15] - Lieferanschrift - Name
							# $line[16] - Lieferanschrift - Straße
							# $line[17] - Lieferanschrift - PLZ
							# $line[18] - Lieferanschrift - Stadt
							# $line[19] - Möbel-Status
							# $line[20] - Position
							# $line[21] - EAN-Nr.
							# $line[22] - Art.Nr.
							# $line[23] - Modelltext
							# $line[24] - Ausführung
							# $line[25] - Stoff Nr.
							# $line[26] - Stoff Text 1
							# $line[27] - Stoff Text 2
							# $line[28] - Füße
							# $line[29] - EK- Termin Woche
							# $line[30] - Preis
							# $line[31] - Referenz
							# $line[32] - Kommission
							# $line[33] - Versand Woche
							# $line[34] - Colli
							# $line[35] - [m3]
							# $line[36] - [kg]
							# $line[37] - Tour nr.
							# $line[38] - Versand Datum
							# $line[39] - Grund für die Rückgabe
							# $line[40] - Transport Nummer
							# $line[41] - Transport Datum
							# $line[42] - Kommentar
							####
							
							if ($line[5] != 75007) {
								if ($line[5] != 70007) {
									continue;
								}
							}
							
							####
							# Buyer - update or insert
							####
							$buyer=Buyer::model()->find(array(
								'condition'=>'buyer_name_1=:name1 AND buyer_name_2=:name2 AND buyer_street=:street AND buyer_zip_code=:zip_code',
								'params'=>array(':name1'=>$line[15], 
									':name2'=>$line[7],
					 				':street'=>$line[16],
									':zip_code'=>$line[17] . " " . $line[18],
								),
								# ostatni element
								'order' => "buyer_id DESC",
								'limit' => 1
							));
							if (empty($buyer)) {
								$buyer=new Buyer('upload');
							}
							$buyer->buyer_name_1=$line[15];
							$buyer->buyer_name_2=$line[7];
							$buyer->buyer_street=$line[16];
							$buyer->buyer_zip_code=$line[17] . " " . $line[18];
							$buyer->save();
							
							####
							# Broker - update or insert
							####
							if ($line[5] == 75007) {
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
							} else if ($line[5] == 70007) {
								$broker=Broker::model()->find(array(
									'condition'=>'broker_name=:name',
									'params'=>array(':name'=>'ReDi GmbH'),
									# ostatni element
									'order' => "broker_id DESC",
									'limit' => 1
								));
								if (empty($broker)) {
									$broker=new Broker('upload');
								}
								$broker->broker_name="ReDi GmbH";
								$broker->save();
							}
							
							####
							# Manufacturer - update or insert
							####
							$manufacturer=Manufacturer::model()->find(array(
								'condition'=>'manufacturer_name=:name AND manufacturer_number=:number',
								'params'=>array(':name'=>$line[6],
												':number'=>$line[5],
								),
								# ostatni element
								'order' => "manufacturer_id DESC",
								'limit' => 1
							));
							if (empty($manufacturer)) {
								$manufacturer=new Manufacturer('upload');
							}
							$manufacturer->manufacturer_number=$line[5];
							$manufacturer->manufacturer_name=$line[6];
							$manufacturer->save();
							
							####
							# Leg - update or insert
							####
							$leg=Leg::model()->find(array(
								'condition'=>'leg_type=:leg',
								'params'=>array(':leg'=>$line[28]),
								#ostatni element
								'order' => "leg_id DESC",
								'limit' => 1
							));
							if (empty($leg)) {
								$leg=new Leg('upload');
							}
							$leg->leg_type=$line[28];
							$leg->save();
							
							####
							# Article - update or insert
							####
							$article=Article::model()->find(array(
								'condition'=>'article_number=:number',
								'params'=>array(':number'=>substr($line[22],0,-1)),
								#ostatni element
								'order' => "article_id DESC",
								'limit' => 1
							));
							if (empty($article)) {
								$article=new Article('upload');
								$article->article_colli=$line[34];
								$article->model_name=$line[23];
								$article->model_type=str_replace("–","-",$line[24]);
							}
							$article->article_number=substr($line[22],0,-1);
							# poprawiamy nazwę/typ modelu na podstawie wzorca - często nazwy w pliku są ucięte
							if (array_key_exists($article->article_number, $correctTypeList)) {
								$article->model_type=$correctTypeList[$article->article_number];
							}
							
							# weryfikujemy poprawność nazwy w zamówieniu z nazwą wynikającą z numeru artykułu (dla SO)
							
							# ignorujemy weryfikację dla wyjątkowych nazw
							$badArticleError=str_replace("–","-",$line[24]);
							$badArticle1Error=null;
							$badArticle2Error=null;
							$badArticle3Error=null;
							if (preg_match('/(kissensatz)/i',$line[24])) { 
								#ignorujemy
								true;
							} else {
							    $patternFunctionList = array(1 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false),
	        		 								  2 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false),
					 			 					  3 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false));
								   
								# najpierw wzór - lista funkcji wynikająca z numeru artykułu
								$pieces = explode("-",$article->model_type);
								$pieces1=$pieces;
						        if (count($pieces) >=1 && count($pieces) <=3) {
							        if (count($pieces) >= 1 ) {
							        	if (preg_match('/(ott)/i',$pieces[0])) { 
							        		$patternFunctionList[1]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["3"]=true; 
								        }
							        	if (preg_match('/(q)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[0]) || preg_match('/(bett)/i',$pieces[0]) || preg_match('/(bk)/i',$pieces[0]) || preg_match('/(inkl)/i',$pieces[0])) { 
								        		$patternFunctionList[1]["Box"]=true; 
								        }
							       }
							       if (count($pieces) > 1 ) {
							        	if (preg_match('/(ott)/i',$pieces[1])) { 
							        		$patternFunctionList[2]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["3"]=true; 
								        }
							        	if (preg_match('/(q)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[1]) || preg_match('/(bett)/i',$pieces[1]) || preg_match('/(bk)/i',$pieces[1]) || preg_match('/(inkl)/i',$pieces[1])) { 
								        		$patternFunctionList[2]["Box"]=true; 
								        }
							        }
									if (count($pieces) > 2 ) {
							        	if (preg_match('/(ott)/i',$pieces[2])) { 
							        		$patternFunctionList[3]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["3"]=true; 
								        }
							        	if (preg_match('/(q)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[2]) || preg_match('/(bett)/i',$pieces[2]) || preg_match('/(bk)/i',$pieces[2]) || preg_match('/(inkl)/i',$pieces[2])) { 
								        		$patternFunctionList[3]["Box"]=true; 
								        }
									}
						        } else {
						        	echo "Niemożliwa liczba części/coli\n dla $line[0] $line[20] $line[24]";
						        	echo "<pre>";
						        	var_dump($pieces);
						        	echo "</pre>";
						        	die();
						        }
						        
						        # lista funkcji wynikająca z nazwy w zamówieniu
								$toComapreFunctionList = array(1 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false),
	        		 									 	   2 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false),
					 			 					 		   3 => array("Ottomane"=>false, "RFu"=>false, "SV"=>false, "3"=>false, "Q"=>false, "LC"=>false, "ALFu"=>false, "Box"=>false));
								   
								$pieces = explode("-",str_replace("–","-",$line[24]));
								$pieces2 = $pieces;
						        if (count($pieces) >=1 && count($pieces) <=3) {
							        if (count($pieces) >= 1 ) {
							        	if (preg_match('/(ott)/i',$pieces[0])) { 
							        		$toComapreFunctionList[1]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[0])) { 
								        		$toComapreFunctionList[1]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[0])) { 
								        		$toComapreFunctionList[1]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[0])) {
								        		$toComapreFunctionList[1]["3"]=true; 
								        }
								        
							        	if (preg_match('/(q)/i',$pieces[0])) { 
								        		$toComapreFunctionList[1]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[0])) { 
								        		$toComapreFunctionList[1]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[0])) { 
								        		$toComapreFunctionList[1]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[0]) || preg_match('/(bett)/i',$pieces[0]) || preg_match('/(bk)/i',$pieces[0]) || preg_match('/(inkl)/i',$pieces[0])) {  
								        		$toComapreFunctionList[1]["Box"]=true; 
								        }
							       }
							       if (count($pieces) > 1 ) {
							        	if (preg_match('/(ott)/i',$pieces[1])) { 
							        		$toComapreFunctionList[2]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["3"]=true; 
								        }
							        	if (preg_match('/(q)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[1]) || preg_match('/(bett)/i',$pieces[1]) || preg_match('/(bk)/i',$pieces[1]) || preg_match('/(inkl)/i',$pieces[1])) { 
								        		$toComapreFunctionList[2]["Box"]=true; 
								        }
							        }
									if (count($pieces) > 2 ) {
							        	if (preg_match('/(ott)/i',$pieces[2])) { 
							        		$toComapreFunctionList[3]["Ottomane"]=true; 
							        	}
								        if (preg_match('/(rf)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["RFu"]=true; 
								        }
								        if (preg_match('/(sv)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["SV"]=true; 
								        }
								        if (preg_match('/(3)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["3"]=true; 
								        }
							        	if (preg_match('/(q)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["Q"]=true; 
								        }
							        	if (preg_match('/(lc)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["LC"]=true; 
								        }
							       		if (preg_match('/(alf)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["ALFu"]=true; 
								        }
							        	if (preg_match('/(box)/i',$pieces[2]) || preg_match('/(bett)/i',$pieces[2]) || preg_match('/(bk)/i',$pieces[2]) || preg_match('/(inkl)/i',$pieces[2])) { 
								        		$toComapreFunctionList[3]["Box"]=true; 
								        }
									}
									$array1_diff=array_diff_assoc($patternFunctionList[1],$toComapreFunctionList[1]);	
							        if (!empty($array1_diff)) {
						        		$badArticle1Error=str_replace("–","-",$line[24]);
					       			}	
									$array2_diff=array_diff_assoc($patternFunctionList[2],$toComapreFunctionList[2]);	
						        	if (!empty($array2_diff)) {
						        		$badArticle2Error=str_replace("–","-",$line[24]);
						        	} 
									$array3_diff=array_diff_assoc($patternFunctionList[3],$toComapreFunctionList[3]);	
					        		if (!empty($array3_diff)) {
					        			$badArticle3Error=str_replace("–","-",$line[24]);
							        } 
								        
									/* # test
						        	echo "<pre>";
						        	var_dump($badArticle1Error);
						        	echo "############\n";
						        	echo $article->model_type . "\n";
						        	echo $line[24] . "\n";
						        	echo "###################\n";
						        	var_dump($pieces1);
						        	echo "###################\n";
						        	var_dump($pieces2);
						        	echo "#######################\n";
						        	var_dump(array_diff_assoc($patternFunctionList[3],$toComapreFunctionList[3]));
						        	echo "###########################\n";
						        	var_dump($patternFunctionList);
						        	echo "###########################\n";
						        	var_dump($toComapreFunctionList);
						        	echo "</pre>";
						        	die(); */
						        } else {
						        	echo "Niemożliwa liczba części/coli\n";
						        	echo "<pre>";
						        	var_dump($pieces);
						        	echo "</pre>";
						        	die();
						        	
						        }
							}
							
							$article->save();
							
							####
							# Textile - update or insert
							####
							
							###
							# Pierwszy deseń
							###
							
							# zebranie informacji o pierwszym deseniu
							if ($line[25]>1350) { #Jeden deseń na zamówieniu
								$textile_number=$line[25];
							} else { # dwa desenie na zamówieniu
								preg_match('/([0-9]{4})/i',$line[26],$matches);
								$textile_number=$matches[1];
							}
							# grupa cenowa
							preg_match('/\(? *PG *([0-9]{1})/',$line[26],$matches);
							$textile_price_group=isset($matches[1]) ? $matches[1] : 99 ;
							
							# textile1 - update or insert
							$textile=Textile::model()->find(array(
								'condition'=>'textile_number=:number AND textile_name=:name AND textile_price_group=:group',
								'params'=>array(':number'=>$textile_number,
												':name'=>$line[26],
												':group'=>$textile_price_group,
								),
								#ostatni element
								'order' => "textile_id DESC",
								'limit' => 1
							));
							if (empty($textile)) {
								$textile=new Textile('upload');
							}
							$textile->textile_number=isset($textile_number) ? $textile_number : "-" ;
							$textile->textile_price_group=isset($textile_price_group) ? $textile_price_group : 99 ;
							$textile->textile_name=$line[26];
							$textile->save();
							
							###
							# Drugi deseń
							###
							$secTextileError=null;
							if ($line[25]<=1350) {
								# grupa cenowa
								//D.4105:Microf. mittelbraun(PG9
								preg_match('/\(? *PG *([0-9]{1})/',$line[27],$matches);
								$textile_price_group=isset($matches[1]) ? $matches[1] : 99 ;
								# numer mat
								preg_match('/([0-9]{4})/i',$line[27],$matches);
								# textile2 - update or insert
								$textile2=Textile::model()->find(array(
									'condition'=>'textile_number=:number AND textile_name=:name AND textile_price_group=:group',
									'params'=>array(':number'=>$matches[1],
									':name'=>$line[27],
									':group'=>$textile_price_group,
									),
									# ostatni element
									'order' => "textile_id DESC",
									'limit' => 1
								));
								if (empty($textile2)) {
									$textile2=new Textile('upload');
								}
								$textile2->textile_number=isset($matches[1]) ? $matches[1] : "-" ;
								$textile2->textile_name=$line[27];
								$textile2->textile_price_group=isset($textile_price_group) ? $textile_price_group : 99 ;
								$textile2->save();
							} else {
								# zgłoś błąd, jeżeli numer pary jest >1350, a pojawi sie drugi deseń
								$test=rtrim(preg_match('/([0-9]{4})/i',$line[27],$matches));
								if (!empty($test)) {
									$secTextileError="sec-textile";
								}
							}
							
							####
							# Order - update or insert
							####
							
							# order_storno_date!=:currenDate -> jeżeli podczas jednego wgrywania pojawi się dubel, to zapisujemy go do bazy
							# na podstawie e-maila wysłanego/odebranego od Bartka Rabsha z dnia: 2015-08-03
							$order=Order::model()->find(array(
								'condition'=>'order_number=:order_number AND article_article_id=:article_id  AND buyer_order_number=:buyer_order_number',
								'params'=>array(':order_number'=>$line[0], ':article_id'=>$article->article_id, ':buyer_order_number'=>$line[20]),
								#ostatni element
								'order' => "order_id DESC",
								'limit' => 1
							));
							if (empty($order)) {
								$order=new Order('upload');
								# jak nowy, to ustaw datę wgrania, w przeciwnym wypadku zostanie poprzednia data wgrania
								$order->order_add_date=$currentDate;
							}
							# storno_date - czyli data aktualizacji
							$order->order_storno_date=$currentDate;
							# oznacz zmianę ilości
							/* if (isset($order->article_amount) && $order->article_amount != $line[24]) {
								$error=explode("|", $order->order_error);
								array_push ( $error , "amount-$order->article_amount");
								$error=implode("|", $error);
								$order->order_error=$error;
							} */
							
							# dalsze przetwarzanie wczytywania zamówienia
							$order->order_price=$line[30];
							$order->article_amount=1;
							$order->order_total_price=$line[30];
							$order->buyer_comments=$line[11];
							$order->buyer_order_number=$line[20];
							$order->order_date=$line[1];
							$order->order_number=$line[0];
							$order->order_reference=$line[31];
							
							preg_match('/([0-9]+)\/([0-9]+)/',$line[29],$matches);
							$week=min($matches[1], $matches[2]);
							$year=max($matches[1], $matches[2]);
							
							$order->order_term="$year/$week";
							/* if (!empty(trim($line[4]))) {
								$order->article_planed=trim($line[4]);
							} */
							
							# jeżeli zamówienie dla Otto (szukaj w drugiej nazwie), to dodaj znacznik w notkach
							if (preg_match('/OTTO GmbH/i',$buyer->buyer_name_2,$matches)) {
								$orderNotes=explode("|", $order->order_notes);
								if (!in_array($matches[0], $orderNotes)) {
									array_push ( $orderNotes , $matches[0]);
								}
								$orderNotes=implode("|", $orderNotes);
								$order->order_notes=$orderNotes;
							}
							
							###
							# Wiązanie Order z innymi tabelami
							###
							$order->article_article_id=$article->article_id;
							$order->leg_leg_id=$leg->leg_id;
							$order->broker_broker_id=$broker->broker_id;
							$order->manufacturer_manufacturer_id=$manufacturer->manufacturer_id;
							
							# jeżeli zmienił się adres dostawy (zmiana id kupującego), to zgłoś błąd
							if (isset($order->buyer_buyer_id) && $order->buyer_buyer_id != $buyer->buyer_id) {
								$buyerError="buyer";
							} else {
								$buyerError=null;
							}
							$order->buyer_buyer_id=$buyer->buyer_id;
							
							###
							# Wiązanie Order z odpowiednimi materiałami, oraz pobranie informacji o nich
							###
							
							#Jeżeli mamy dwa desenie							
							if ($line[25]<=1350) {
								$order->textil_pair=$line[25];
								$order->textile2_textile_id=$textile2->textile_id;
								# Uśredniamy grupę cenową
								$order->textilpair_price_group=round(($textile->textile_price_group+$textile2->textile_price_group)/2);
							} else {
								$order->textile2_textile_id=null;
							}
							# pierwszy deseń zawsze występuje
							$order->textile1_textile_id=$textile->textile_id;
							
							###
							# Dodatkowe operacje
							###
							
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
							
							# oznacz błąd typu "sec-textile" wykryty w sekcji "Textile - update or insert"
							if (isset($secTextileError)) {
								$error=explode("|", $order->order_error);
								if (!in_array($secTextileError, $error)) {
									array_push ( $error , $secTextileError);
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							# oznacz błąd typu "buyer" wykryty w sekcji "Wiązanie Order z innymi tabelami"
							if (isset($buyerError)) {
								$error=explode("|", $order->order_error);
								if (!in_array($buyerError, $error)) {
									array_push ( $error , $buyerError);
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							# oznacz błąd typu "bad_article" wykryty w sekcji "update or insert article"
							if (isset($badArticle1Error)) {
								$error=explode("|", $order->order_error);
								if (!in_array("bad_article1", $error)) {
									array_push ( $error , "bad_article1");
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							/* if (isset($badArticle2Error)) {
								$error=explode("|", $order->order_error);
								if (!in_array("bad_article2", $error)) {
									array_push ( $error , "bad_article2");
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							}
							
							if (isset($badArticle3Error)) {
								$error=explode("|", $order->order_error);
								if (!in_array("bad_article3", $error)) {
									array_push ( $error , "bad_article3");
								}
								$error=implode("|", $error);
								$order->order_error=$error;
							} */
							
							# jak bad_article, to dodaj nazwę z zamówienia do notatek
							if (isset($badArticle1Error) || isset($badArticle2Error) || isset($badArticle3Error)) {
					        	$orderNotes=explode("|", $order->order_notes);
								if (!in_array($badArticleError, $orderNotes)) {
									array_push ( $orderNotes , $badArticleError);
								}
								$orderNotes=implode("|", $orderNotes);
								$order->order_notes=$orderNotes;
							}
							
							###
							# Finalny zapis Order
							###
							$order->save();
							
						}
						fclose($handle);
						unlink($file);
					}
					$transaction->commit();
					Yii::app()->user->setFlash('4success','Zamówienia wgrane bez krytycznych błędów. Drobne błędy zostały naniesione w kolumnie błąd.');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('4error','Nie udało się wgrać zamówień.');
					echo "<pre>"; var_dump($e); echo "</pre>";
				}
				
				# wyszukaj potencjalne storna
				//TO DO - w sytuacji nie wgrania żadnego z zamówień program wszystko potraktuje jako strono - do poprawy
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
					Yii::app()->user->setFlash('5success','Wyszukiwanie potencjalnych "storn" zakońcone powodzeniem.');
				} catch(Exception $e) {
					$transaction->rollBack();
					Yii::app()->user->setFlash('5error','Nie udało się wyszukiwanie potencjalnych "storn"');
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
		$this->layout='//layouts/column1';
		
		if (isset($_POST["summary"]) && isset($_POST["select"])) {
			#Budujemy tablicę pod zapytanie wyszukujące chciane krotki
			$pks=array();
			foreach ($_POST["select"] as $id => $checked) {
				array_push($pks, $checked);
			}
			#Pozycje na potrzeby faktury (zgrupowane)
			$Orders1=Order::model()->findAllByPk($pks, array(
				'select'=>array(
					'articleArticle.article_number as articleArticle_article_number',
					'articleArticle.model_name as articleArticle_model_name',
					'articleArticle.model_type as articleArticle_model_type',
					new CDbExpression('IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group) as fabrics_fabric_price_group'),
					'articleArticle.article_all_textile_amount as articleArticle_article_all_textile_amount',
					 'SUM(t.article_amount) as article_amount',
					 't.order_total_price as order_price',
					 'articleArticle.price_in_pg1 as articleArticle_price_in_pg1',
					 'articleArticle.price_in_pg2 as articleArticle_price_in_pg2',
					 'articleArticle.price_in_pg3 as articleArticle_price_in_pg3',
					 'articleArticle.price_in_pg4 as articleArticle_price_in_pg4',
					 'articleArticle.price_in_pg5 as articleArticle_price_in_pg5',
					 'articleArticle.price_in_pg6 as articleArticle_price_in_pg6',
					 'articleArticle.price_in_pg7 as articleArticle_price_in_pg7',
					
				),
				'with'=>array('articleArticle', 
							  'textile1Textile'=>array('with'=>'fabric1', 'together'=>true), 
							  'textile2Textile'=>array('with'=>'fabric2', 'together'=>true)
				),
				'together'=>true,
				'group'=>'articleArticle.article_number,
						  articleArticle.model_name, 
						  articleArticle.model_type, 
						  IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group),
						  articleArticle.article_all_textile_amount, 
						  t.order_total_price, 
						  articleArticle.price_in_pg1, 
						  articleArticle.price_in_pg2, 
						  articleArticle.price_in_pg3, 
						  articleArticle.price_in_pg4, 
						  articleArticle.price_in_pg5, 
						  articleArticle.price_in_pg6, 
						  articleArticle.price_in_pg7',
				'order'=>'articleArticle.article_number ASC, 
						  IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group) ASC',
			));
			
			#Numery zamówień na potrzeby faktury
			$Orders2=Order::model()->findAllByPk($pks, array(
				'select'=>'DISTINCT order_number',
				'order'=>'order_number ASC',
			));
			
			#Pozycje na potrzeby faktury (szczegóły)
			$Orders3=Order::model()->findAllByPk($pks, array(
				'select'=>array(
					'articleArticle.article_number as articleArticle_article_number',
					'articleArticle.model_name as articleArticle_model_name',
					'articleArticle.model_type as articleArticle_model_type',
					'textile1Textile.textile_number as textiles1_textile_number',
					'textile2Textile.textile_number as textiles2_textile_number',
					'fabric1.fabric_price_group as textiles1_textile_price_groupe',
					'fabric2.fabric_price_group as textiles2_textile_price_groupe',
					new CDbExpression('IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group) as fabrics_fabric_price_group'),
					'articleArticle.article_all_textile_amount as articleArticle_article_all_textile_amount',
					 'SUM(t.article_amount) as article_amount',
					 't.order_total_price as order_price',
					 'articleArticle.price_in_pg1 as articleArticle_price_in_pg1',
					 'articleArticle.price_in_pg2 as articleArticle_price_in_pg2',
					 'articleArticle.price_in_pg3 as articleArticle_price_in_pg3',
					 'articleArticle.price_in_pg4 as articleArticle_price_in_pg4',
					 'articleArticle.price_in_pg5 as articleArticle_price_in_pg5',
					 'articleArticle.price_in_pg6 as articleArticle_price_in_pg6',
					 'articleArticle.price_in_pg7 as articleArticle_price_in_pg7',
					
				),
				'with'=>array('articleArticle', 
							  'textile1Textile'=>array('with'=>'fabric1', 'together'=>true), 
							  'textile2Textile'=>array('with'=>'fabric2', 'together'=>true)
				),
				'together'=>true,
				'group'=>'articleArticle.article_number,
						  articleArticle.model_name, 
						  articleArticle.model_type, 
							textile1Textile.textile_number,
							textile2Textile.textile_number,
							fabric1.fabric_price_group,
							fabric2.fabric_price_group,
						  IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group),
						  articleArticle.article_all_textile_amount, 
						  t.order_total_price, 
						  articleArticle.price_in_pg1, 
						  articleArticle.price_in_pg2, 
						  articleArticle.price_in_pg3, 
						  articleArticle.price_in_pg4, 
						  articleArticle.price_in_pg5, 
						  articleArticle.price_in_pg6, 
						  articleArticle.price_in_pg7',
				'order'=>'articleArticle.article_number ASC, 
						  IFNULL(ROUND((fabric1.fabric_price_group + fabric2.fabric_price_group)/2),fabric1.fabric_price_group) ASC',
			));
			
			#Rozkład tygodniowy poszczególnych modeli
			$Orders4=Order::model()->findAllByPk($pks, array(
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
			
			#Rozkład poszczególnych modeli
			$Orders5=Order::model()->findAllByPk($pks, array(
				'select'=>array(
					'articleArticle.article_number as articleArticle_article_number',
					'articleArticle.model_name as articleArticle_model_name',
					'articleArticle.model_type as articleArticle_model_type',
					new CDbExpression('SUM(t.article_amount) as article_amount'),
				),
				'with'=>array('articleArticle'),
				'together'=>true,
				'group'=>'articleArticle.article_number,
						  articleArticle.model_name, 
						  articleArticle.model_type',
				'order'=>'articleArticle.model_name ASC, articleArticle.article_number ASC',
			));
			
			#Plan - sieroty
			$Orders6=Order::model()->findAll(array(
				'select'=>array(
					'order_number',
					'buyer_order_number',
					'article_planed'
				),
				'order'=>'article_planed ASC, order_number ASC, buyer_order_number ASC',
				'condition'=>'article_exported IS NULL AND article_canceled=0 AND article_planed IS NULL AND
							  order_number IN (SELECT order_number FROM `order` WHERE article_planed IS NOT NULL and article_exported IS NULL AND article_canceled=0)'
			));
			
			#Lista na potrzeby przeniesienia planu
			$Orders7=Order::model()->findAll(array(
				'select'=>array(
					new CDbExpression('CONCAT_WS("_", order_number, buyer_order_number) as order_number'),
					new CDbExpression('SUBSTRING(article_planed,1,2) as article_planed')
				),
				'order'=>'article_planed ASC, order_number ASC, buyer_order_number ASC',
				'condition'=>'article_planed IS NOT NULL and article_exported IS NULL AND article_canceled=0'
			));
			
			$this->render('summary',array(
					'Orders1'=>$Orders1, 
					'Orders2'=>$Orders2,
					'Orders3'=>$Orders3,
					'Orders4'=>$Orders4,
					'Orders5'=>$Orders5,
					'Orders6'=>$Orders6,
					'Orders7'=>$Orders7,
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
				'fabric_name',
				new CDbExpression('SUM(textiles_selected) as textiles_selected'),
				'textiles_ordered',
				new CDBExpression('CONCAT(IFNULL(GROUP_CONCAT(order1_id),""),IF(GROUP_CONCAT(order1_id),",","")) as order1_number'),
				new CDBExpression('CONCAT(IFNULL(GROUP_CONCAT(order2_id),""),IF(GROUP_CONCAT(order2_id),",","")) as order2_number')
			);
			$criteria->addInCondition('order1_id',$pks, 'AND');
			$criteria->addInCondition('order2_id',$pks, 'OR');
			$criteria->group='supplier_name, textile_number, fabric_name, textiles_ordered';
			$criteria->order='supplier_name ASC, textile_number ASC';
			#wyszukiwanie
			$rapTextile=RapTextiles::model()->findAll($criteria);
			
			#Budujemy model na potrzeby formularza dodającego zakup (zamówienie materiałów)
			foreach ($rapTextile as $key => $textile) {
				#tworzymy tablice modeli typu Shopping - tutaj będziemy zbierać dane, które zostaną zpaisane
				$shoppings[$key]=new Shopping;
				$shoppings[$key]->fabric_collection_fabric_id=FabricCollection::model()->find(array(
					'condition'=>'fabric_number = :textile_number',
					'params'=>array(':textile_number'=>$textile->textile_number),
					'order'=>'fabric_id ASC',
					'limit'=>1
				))->fabric_id;
				$shoppings[$key]->article_calculated_amount=$textile->textiles_selected;
				$shoppings[$key]->order1_ids=$textile->order1_number;
				$shoppings[$key]->order2_ids=$textile->order2_number;
			}
			
			
			$this->render('textile_summary',array(
					'rapTextile'=>$rapTextile,
					'shoppings'=>$shoppings
			));
			}
		}
	
	public function actionMobileScaned() {
		if (isset($_POST["data"])) {
			#zdekodowanie otrzymanych danych
			$json = json_decode($_POST["data"]);
			
			#liczymy ilości dla każdego id w tablicy, a dopiero póniej zapisujemy policzone do bazy
			$orders=array();
			foreach ($json->values as $key => $values) {
				$id=substr($values, 0, 7);
				$count=substr($values, 7, 3);
				$coli=substr($values, 10, 1);
				$coli_amount=substr($values, 11, 1);
				
				# inicjujemy indeks, na potrzeby dalszej inkrementacji
				if (!array_key_exists($id, $orders)) {
					$orders[$id]["count"] = 0;
					# osobno zliczamy coli dla kroju i tapicernii
					$orders[$id]["cut_coli"] = 0;
					$orders[$id]["upholstery_coli"] = 0;
				} 
				
				# W przypadku skanowanie etykiet z kroju nie rozróżniamy coli, z tąd otrzymujemy wartość 0,
	        	# którą traktujemy, tak jakby wszystkie coli były zeskanowane.
	        	if ($coli == 0) {
	        		$orders[$id]["cut_coli"]+=$coli_amount;
	        	} else {
					$orders[$id]["upholstery_coli"]+=1;
	        	}
				
	        	# jw. 0 coli traktujemy tak jakby wszystkie były zeskanowane, co jest podobne do zeskanowania 1 z 1 coli
				if ($coli_amount == 1 || $coli == 0) {
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
					$totalBadColi+=$values["cut_coli"] + $values["upholstery_coli"];
					
					#pobranie listy kodów kreskowych
					foreach ($json->values as $nothing => $barcode) {
						$id=substr($barcode, 0, 7);
						if ($id == $key) {
							$badOrders[$barcode]=$barcode;
						}
					}
				} else {
					$order->article_manufactured+=$values["upholstery_coli"];
					$order->textile_prepared+=$values["cut_coli"];
					$order->save();
					$totalCount+=$values["count"];
					$totalColi+=$values["cut_coli"] + $values["upholstery_coli"];
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
		if (isset($_POST) && isset($_POST["minilabel"])) {
			if (isset($_POST["select"])) {
				#Przygotowanie wydruku
				// Instanciation of inherited class
				$pdf = new MiniLabel('P','mm','A4');
				$pdf->AliasNbPages();
				$pdf->SetMargins(5, 10, 5);
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
						$pdf->articleName=iconv('utf-8', 'windows-1250',$Order->articleArticle->model_name);
						$pdf->articleType=iconv('utf-8', 'windows-1250',$Order->articleArticle->model_type);
						
						$textileNumber1=$Order->textile1Textile->textile_number;
						$textileName1= $Order->textile1Textile->textile_name;
						$textileNumber2=isset($Order->textile2Textile->textile_number) ? $Order->textile2Textile->textile_number : "" ;
						$textileName2=isset($Order->textile2Textile->textile_name) ? $Order->textile2Textile->textile_name : "" ;
						
						$pdf->textileNumber1=iconv('utf-8', 'windows-1250',$textileNumber1);
						$pdf->textileName1=iconv('utf-8', 'windows-1250',$textileName1);
						$pdf->textileNumber2=iconv('utf-8', 'windows-1250',$textileNumber2);
						$pdf->textileName2=iconv('utf-8', 'windows-1250',$textileName2);
						
						$pdf->orderDate=$Order->order_term;
						
						# odred_id + (3) sztuka + (1) numer coli (w przypadku materiału zawsze 0, co oznacza wszystkie) + (1) ilość coli
						$pdf->qrcode=$Order->order_id . sprintf('%03d', $i) . "0" . $Order->articleArticle->article_colli;
						
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
		if (isset($_POST) && isset($_POST["ladeliste"])) {
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
		if (isset($_POST) && isset($_POST["shipping_label"])) {
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
							
							# tablica z dodatkowymi nazwami dla Otto
							$ottoStoffNumber=array(
								4081 => 'Otto-Stoffnummer: 110',
								4085 => 'Otto-Stoffnummer: 111',
								4092 => 'Otto-Stoffnummer: 112',
								4020 => 'Otto-Stoffnummer: 120',
								4021 => 'Otto-Stoffnummer: 121',
								4022 => 'Otto-Stoffnummer: 122',
								4023 => 'Otto-Stoffnummer: 123',
								4024 => 'Otto-Stoffnummer: 124',
								4058 => 'Otto-Stoffnummer: 125',
								4093 => 'Otto-Stoffnummer: 130',
								4094 => 'Otto-Stoffnummer: 131',
								4095 => 'Otto-Stoffnummer: 132',
								4096 => 'Otto-Stoffnummer: 133',
								4097 => 'Otto-Stoffnummer: 134',
								4098 => 'Otto-Stoffnummer: 135',
							);
							 
							# zebranie danych
							$pdf->order_term=$order_term;
							$pdf->model=$Order->articleArticle->model_name . " " . $Order->articleArticle->model_type;
							$pdf->variant="";
							$pdf->fusse=$Order->legLeg->leg_type;
							$pdf->empfanger=$Order->buyerBuyer->buyer_name_2;
							$pdf->lieferant=$Order->brokerBroker->broker_name;
							$pdf->auftragNr=$Order->order_number;
							$pdf->bestellnummer=$Order->buyer_order_number;
							$pdf->lieferanschrift=$Order->buyerBuyer->buyer_name_1;;
							$pdf->strasse=$Order->buyerBuyer->buyer_street;
							$pdf->plz=$Order->buyerBuyer->buyer_zip_code;
							$pdf->artikelNr=$Order->articleArticle->article_number;
							$pdf->eanNummer="";
							$pdf->number=$j;
							$pdf->totalNumber=$Order->articleArticle->article_colli;
				
							if(isset($Order->textil_pair)) {
								$dess1=$Order->textil_pair . "; " . $Order->textile1Textile->textile_name;
							} else {
								$dess1=$Order->textile1Textile->textile_number . "; " . $Order->textile1Textile->textile_name;
							}
							$dess2=isset($Order->textile2Textile->textile_name)? "; " . $Order->textile2Textile->textile_name : " ";
							# dla Otto dodajemy na wydruku specjalną nazwę materiału
							if (preg_match('/OTTO GmbH/i',$Order->buyerBuyer->buyer_name_2,$matches) && array_key_exists($Order->textile1Textile->textile_number, $ottoStoffNumber)) {
								$dess1=$Order->textile1Textile->textile_number . ' - ' . $ottoStoffNumber[$Order->textile1Textile->textile_number];
							}
							if (preg_match('/OTTO GmbH/i',$Order->buyerBuyer->buyer_name_2,$matches) && array_key_exists($Order->textile1Textile->textile_number, $ottoStoffNumber)) {
								$dess2=isset($Order->textile2Textile->textile_number)? '; ' . $Order->textile2Textile->textile_number . ' - ' . $ottoStoffNumber[$Order->textile2Textile->textile_number] : "";
							}  
							$pdf->dessin=$dess1 . " " . $dess2;
							
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
				} else if ($_GET["week_number"] == "/2016"){
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
			$criteria->order='order_term ASC, order_number ASC, buyer_order_number ASC, articleArticle.article_number ASC';
		} else {
			$criteria->order='-article_planed DESC, order_term ASC, order_number ASC, buyer_order_number ASC, articleArticle.article_number ASC';
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
