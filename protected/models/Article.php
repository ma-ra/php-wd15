<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $article_id
 * @property string $article_number
 * @property string $model_name
 * @property string $model_type
 * @property string $model_description
 * @property integer $article_colli
 * @property string $article_all_textile_amount
 * @property string $article_first_textile_amount
 * @property string $article_second_textile_amount
 * @property string $price_in_pg1
 * @property string $price_in_pg2
 * @property string $price_in_pg3
 * @property string $price_in_pg4
 * @property string $price_in_pg5
 * @property string $price_in_pg6
 * @property string $price_in_pg7
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Article extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_number, model_name, model_type', 'required'),
			array('article_colli', 'numerical', 'integerOnly'=>true),
			array('article_number', 'length', 'max'=>50),
			array('model_name, model_type', 'length', 'max'=>100),
		    array('model_description', 'length', 'max'=>450),
			array('article_all_textile_amount, article_first_textile_amount, article_second_textile_amount, price_in_pg1, price_in_pg2, price_in_pg3, price_in_pg4, price_in_pg5, price_in_pg6, price_in_pg7', 'length', 'max'=>9),
			array('article_all_textile_amount, article_first_textile_amount, article_second_textile_amount, price_in_pg1, price_in_pg2, price_in_pg3, price_in_pg4, price_in_pg5, price_in_pg6, price_in_pg7', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('article_id, article_number, model_name, model_type, model_description, article_colli, article_all_textile_amount, article_first_textile_amount, article_second_textile_amount, price_in_pg1, price_in_pg2, price_in_pg3, price_in_pg4, price_in_pg5, price_in_pg6, price_in_pg7', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orders' => array(self::HAS_MANY, 'Order', 'article_article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => 'id artykułu',
			'article_number' => 'numer artykułu',
			'model_name' => 'model',
			'model_type' => 'typ',
		    'model_description' => 'opis modelu',
			'article_colli' => 'colli',
			'article_all_textile_amount' => 'ilość materiału (m)',
			'article_first_textile_amount' => 'Deseń 1 - ilość materiału (m)',
			'article_second_textile_amount' => 'Deseń 2 - ilość materiału (m)',
			'price_in_pg1' => 'PG1',
			'price_in_pg2' => 'PG2',
			'price_in_pg3' => 'PG3',
			'price_in_pg4' => 'PG4',
			'price_in_pg5' => 'PG5',
			'price_in_pg6' => 'PG6',
			'price_in_pg7' => 'PG7',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('article_number',$this->article_number,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_type',$this->model_type,true);
		$criteria->compare('model_description',$this->model_description,true);
		$criteria->compare('article_colli',$this->article_colli);
		$criteria->compare('article_all_textile_amount',$this->article_all_textile_amount);
		$criteria->compare('article_first_textile_amount',$this->article_first_textile_amount);
		$criteria->compare('article_second_textile_amount',$this->article_second_textile_amount);
		$criteria->compare('price_in_pg1',$this->price_in_pg1,true);
		$criteria->compare('price_in_pg2',$this->price_in_pg2,true);
		$criteria->compare('price_in_pg3',$this->price_in_pg3,true);
		$criteria->compare('price_in_pg4',$this->price_in_pg4,true);
		$criteria->compare('price_in_pg5',$this->price_in_pg5,true);
		$criteria->compare('price_in_pg6',$this->price_in_pg6,true);
		$criteria->compare('price_in_pg7',$this->price_in_pg7,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
