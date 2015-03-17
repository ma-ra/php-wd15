<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $order_id
 * @property string $order_number
 * @property string $order_date
 * @property string $buyer_order_number
 * @property string $buyer_comments
 * @property string $order_reference
 * @property string $order_term
 * @property integer $article_amount
 * @property integer $buyer_buyer_id
 * @property integer $broker_broker_id
 * @property integer $manufacturer_manufacturer_id
 * @property integer $leg_leg_id
 * @property integer $article_article_id
 * @property integer $textile_order
 * @property integer $printed_minilabel
 * @property integer $printed_shipping_label
 * @property integer $article_manufactured
 * @property integer $article_exported
 *
 * The followings are the available model relations:
 * @property Buyer $buyerBuyer
 * @property Broker $brokerBroker
 * @property Manufacturer $manufacturerManufacturer
 * @property Leg $legLeg
 * @property Article $articleArticle
 * @property Textile[] $textiles
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_number, order_term, article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id', 'required'),
			array('article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id, textile_order, printed_minilabel, printed_shipping_label, article_manufactured, article_exported', 'numerical', 'integerOnly'=>true),
			array('order_number', 'length', 'max'=>15),
			array('buyer_order_number, order_term', 'length', 'max'=>50),
			array('buyer_comments, order_reference', 'length', 'max'=>150),
			array('order_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, order_number, order_date, buyer_order_number, buyer_comments, order_reference, order_term, article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id, textile_order, printed_minilabel, printed_shipping_label, article_manufactured, article_exported', 'safe', 'on'=>'search'),
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
			'buyerBuyer' => array(self::BELONGS_TO, 'Buyer', 'buyer_buyer_id'),
			'brokerBroker' => array(self::BELONGS_TO, 'Broker', 'broker_broker_id'),
			'manufacturerManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_manufacturer_id'),
			'legLeg' => array(self::BELONGS_TO, 'Leg', 'leg_leg_id'),
			'articleArticle' => array(self::BELONGS_TO, 'Article', 'article_article_id'),
			'textiles' => array(self::MANY_MANY, 'Textile', 'order_has_textile(order_order_id, textile_textile_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'id zamówienia',
			'order_number' => 'numer zamówienia',
			'order_date' => 'data zamówienia',
			'buyer_order_number' => 'nr. zam. klienta',
			'buyer_comments' => 'uwagi klienta',
			'order_reference' => 'referencje',
			'order_term' => 'termin',
			'article_amount' => 'liczba sztuk',
			'buyer_buyer_id' => 'id kupującego',
			'broker_broker_id' => 'id pośrednika',
			'manufacturer_manufacturer_id' => 'id producenta',
			'leg_leg_id' => 'id nogi',
			'article_article_id' => 'id artykułu',
			'textile_order' => 'kolejność desenii',
			'printed_minilabel' => 'mini etykieta',
			'printed_shipping_label' => 'etykieta transportowa',
			'article_manufactured' => 'wyprodukowano',
			'article_exported' => 'wywieziono',
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

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('buyer_order_number',$this->buyer_order_number,true);
		$criteria->compare('buyer_comments',$this->buyer_comments,true);
		$criteria->compare('order_reference',$this->order_reference,true);
		$criteria->compare('order_term',$this->order_term,true);
		$criteria->compare('article_amount',$this->article_amount);
		$criteria->compare('buyer_buyer_id',$this->buyer_buyer_id);
		$criteria->compare('broker_broker_id',$this->broker_broker_id);
		$criteria->compare('manufacturer_manufacturer_id',$this->manufacturer_manufacturer_id);
		$criteria->compare('leg_leg_id',$this->leg_leg_id);
		$criteria->compare('article_article_id',$this->article_article_id);
		$criteria->compare('textile_order',$this->textile_order);
		$criteria->compare('printed_minilabel',$this->printed_minilabel);
		$criteria->compare('printed_shipping_label',$this->printed_shipping_label);
		$criteria->compare('article_manufactured',$this->article_manufactured);
		$criteria->compare('article_exported',$this->article_exported);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>100),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
