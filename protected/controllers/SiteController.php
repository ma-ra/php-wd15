<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		#Jak PHP działa na FastCGI/CGI, to w .htaccess dodajemy poniższy kod, a w php wykonujemy poniższą komendę
			#Dodajemy w .htaccess
			/* <IfModule mod_rewrite.c>
			 RewriteEngine on
			 RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]
			 </IfModule> */
		if (!isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
			list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':' , base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
		}
		
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="Logowanie do aplikacji WD15"');
			header('HTTP/1.0 401 Unauthorized');
			throw new CHttpException(401, 'Brak dostępu, nieudane logowanie.');
		} else {
			// logowanie użytkownika za pomocą nazwy użytkownika oraz hasła
			if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
				$identity=new UserIdentity($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
				if($identity->authenticate()) {
					Yii::app()->user->login($identity);
					$this->redirect(Yii::app()->user->returnUrl);
				} else {
					throw new CHttpException(401, 'Brak dostępu, nieudane logowanie.');
				}
			}
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}