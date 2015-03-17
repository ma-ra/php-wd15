<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UploadForm extends CFormModel
{
	public $file;
	public $file_extension;
	public $file_mime;
	public $file_size;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('file', 'file', 'types'=>'csv'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'file'=>'Wybierz plik',
			'file_extension'=>'Rozszerzenie pliku',
			'file_size'=>'Rozmiar pliku',
			'file_mime'=>'typ mime pliku'
		);
	}
}
