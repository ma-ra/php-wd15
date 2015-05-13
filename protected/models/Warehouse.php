<?php

/**
 * This is the model class for table "warehouse".
 *
 * The followings are the available columns in table 'warehouse':
 * @property integer $warehouse_id
 * @property string $warehouse_type
 * @property string $article_number
 * @property string $article_name
 * @property string $article_count
 * @property string $article_price
 * @property string $document_name
 * @property string $warehouse_error
 * @property integer $shopping_shopping_id
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property Shopping $shoppingShopping
 * @property Textile $articleNumber
 */
class Warehouse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'warehouse';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warehouse_type, article_number, article_name, article_count, document_name, creation_date', 'required'),
			array('shopping_shopping_id', 'numerical', 'integerOnly'=>true),
			array('warehouse_type, article_number, article_name, document_name, warehouse_error', 'length', 'max'=>50),
			array('article_count, article_price', 'length', 'max'=>9),
			array('shopping_shopping_id, warehouse_error, article_price', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('warehouse_id, warehouse_type, article_number, article_name, article_count, article_price, document_name, warehouse_error, shopping_shopping_id, creation_date', 'safe', 'on'=>'search'),
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
			'shoppingShopping' => array(self::BELONGS_TO, 'Shopping', 'shopping_shopping_id'),
			'articleNumber' => array(self::BELONGS_TO, 'Textile', 'article_number'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'warehouse_id' => 'id',
			'warehouse_type' => 'typ',
			'article_number' => 'numer',
			'article_name' => 'nazwa',
			'article_count' => 'ilość',
			'article_price' => 'cena',
			'document_name' => 'dokument',
			'warehouse_error' => 'error',
			'shopping_shopping_id' => 'id zakupu',
			'creation_date' => 'data utworzenia',
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

		$criteria->compare('warehouse_id',$this->warehouse_id);
		$criteria->compare('warehouse_type',$this->warehouse_type,true);
		$criteria->compare('article_number',$this->article_number,true);
		$criteria->compare('article_name',$this->article_name,true);
		$criteria->compare('article_count',$this->article_count,true);
		$criteria->compare('article_price',$this->article_price,true);
		$criteria->compare('document_name',$this->document_name,true);
		$criteria->compare('warehouse_error',$this->warehouse_error,true);
		$criteria->compare('shopping_shopping_id',$this->shopping_shopping_id);
		$criteria->compare('creation_date',$this->creation_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>200),
		));
	}
	
	public function summary()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
	
		$criteria=new CDbCriteria;
		$criteria->select='article_number, SUM(article_count) as article_count, SUM(article_price) as article_price';
		$criteria->group='article_number';
		$criteria->order='article_number ASC';
	
		$criteria->compare('article_number',$this->article_number,true);
	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array('pageSize'=>200),
		));
	}
	
	public function beforeValidate() {
		$this->warehouse_type='textil';
		$this->creation_date=date('Y-m-d H:i:s');
			
		return parent::beforeValidate();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Warehouse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
