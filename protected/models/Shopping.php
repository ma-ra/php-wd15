<?php

/**
 * This is the model class for table "shopping".
 *
 * The followings are the available columns in table 'shopping':
 * @property integer $shopping_id
 * @property integer $shopping_number
 * @property string $shopping_type
 * @property integer $textile_textile_id
 * @property string $article_amount
 * @property string $article_calculated_amount
 * @property string $shopping_term
 * @property string $shopping_status
 * @property string $shopping_printed
 * @property string $creation_time
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Textile $textileTextile
 * @property Warehouse[] $warehouses
 */
class Shopping extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shopping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shopping_number, shopping_type, textile_textile_id, article_calculated_amount, creation_time', 'required'),
			array('shopping_number, textile_textile_id', 'numerical', 'integerOnly'=>true),
			array('shopping_type, shopping_status', 'length', 'max'=>50),
			array('article_amount, article_calculated_amount', 'length', 'max'=>9),
			array('shopping_term, shopping_printed', 'safe'),
			array('article_amount, shopping_term, shopping_status, shopping_printed', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('shopping_number, shopping_id, shopping_type, textile_textile_id, article_amount, article_calculated_amount, shopping_term, shopping_status, shopping_printed, creation_time', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'shopping_shopping_id'),
			'textileTextile' => array(self::BELONGS_TO, 'Textile', 'textile_textile_id'),
			'warehouses' => array(self::HAS_MANY, 'Warehouse', 'shopping_shopping_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'shopping_id' => 'id',
			'shopping_number' => 'numer',
			'shopping_type' => 'typ',
			'textile_textile_id' => 'id materiału',
			'article_amount' => 'ilość',
			'article_calculated_amount' => 'wyliczona ilość',
			'shopping_term' => 'termin',
			'shopping_status' => 'status',
			'shopping_printed' => 'wydrukowane',
			'creation_time' => 'data utworzenia',
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

		$criteria->compare('shopping_id',$this->shopping_id);
		$criteria->compare('shopping_number',$this->shopping_number);
		$criteria->compare('shopping_type',$this->shopping_type,true);
		$criteria->compare('textile_textile_id',$this->textile_textile_id);
		$criteria->compare('article_amount',$this->article_amount,true);
		$criteria->compare('article_calculated_amount',$this->article_calculated_amount,true);
		$criteria->compare('shopping_term',$this->shopping_term,true);
		$criteria->compare('shopping_status',$this->shopping_status,true);
		$criteria->compare('shopping_printed',$this->shopping_printed,true);
		$criteria->compare('creation_time',$this->creation_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeValidate() {
		$this->shopping_type='textil';
		$this->creation_time=date('Y-m-d H:i:s');
			
		return parent::beforeValidate();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shopping the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
