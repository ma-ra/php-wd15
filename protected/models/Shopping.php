<?php

/**
 * This is the model class for table "shopping".
 *
 * The followings are the available columns in table 'shopping':
 * @property integer $shopping_id
 * @property integer $shopping_number
 * @property string $shopping_type
 * @property integer $fabric_collection_fabric_id
 * @property string $article_amount
 * @property string $article_calculated_amount
 * @property string $shopping_term
 * @property string $shopping_date_of_shipment
 * @property string $shopping_delivery_date
 * @property string $shopping_scheduled_delivery
 * @property string $article_delivered_amount
 * @property string $article_price
 * @property string $document_name
 * @property string $invoice_name
 * @property string $shopping_notes
 * @property string $shopping_status
 * @property integer $paid
 * @property string $shopping_printed
 * @property string $creation_time
 *
 * The followings are the available model relations:
 * @property Order[] $orders1
 * @property Order[] $orders2
 */
class Shopping extends CActiveRecord
{
	
	public $order1_ids;
	public $order2_ids;
	public $textile_supplier_supplier_name;
	public $textile_textile_number;
	public $textile_textile_name;
	
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
			array('shopping_number, shopping_type, fabric_collection_fabric_id, article_amount, shopping_status, creation_time', 'required'),
			array('shopping_number, fabric_collection_fabric_id, paid', 'numerical', 'integerOnly'=>true),
			array('shopping_type, shopping_status, shopping_term, shopping_date_of_shipment, shopping_scheduled_delivery, shopping_notes', 'length', 'max'=>50),
			array('article_amount, article_calculated_amount, article_delivered_amount, article_price', 'length', 'max'=>9),
			array('document_name, invoice_name', 'length', 'max'=>150),
			array('shopping_delivery_date, shopping_printed', 'safe'),
				
				
			array('article_calculated_amount, 
				      shopping_term, 
					  shopping_status, 
					  shopping_printed, 
					  shopping_date_of_shipment, 
					  shopping_delivery_date, 
					  shopping_scheduled_delivery, 
					  article_delivered_amount, 
					  article_price, 
					  document_name, 
					  invoice_name, 
					  shopping_notes', 
				  'default', 'setOnEmpty' => true, 'value' => null),
				
				
			array('paid', 'default', 'setOnEmpty' => true, 'value' => 0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('shopping_number, shopping_id, shopping_type, fabric_collection_fabric_id, article_amount, article_calculated_amount, shopping_term, shopping_status, shopping_printed, creation_time, textile_supplier_supplier_name, textile_textile_number, textile_textile_name, shopping_date_of_shipment, shopping_delivery_date, shopping_scheduled_delivery, shopping_notes, article_delivered_amount, article_price, document_name, invoice_name, paid', 'safe', 'on'=>'search'),
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
			'orders1' => array(self::HAS_MANY, 'Order', 'shopping1_shopping_id'),
			'orders2' => array(self::HAS_MANY, 'Order', 'shopping2_shopping_id'),
			'fabricCollectionFabric' => array(self::BELONGS_TO, 'FabricCollection', 'fabric_collection_fabric_id'),
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
			'fabric_collection_fabric_id' => 'id materiału',
			'article_amount' => 'ilość',
			'article_calculated_amount' => 'wyliczona ilość',
			'shopping_term' => 'termin',
			'shopping_date_of_shipment' => 'data wysyłki',
			'shopping_delivery_date' => 'data dostarczenia',
			'shopping_scheduled_delivery' => 'planowana dostawa',
			'article_delivered_amount' => 'dostarczona ilość',
			'article_price' => 'cena',
			'document_name' => 'nazwa dokumentu',
			'invoice_name' => 'nazwa faktury',
			'shopping_notes' => 'notatki',
			'shopping_status' => 'status zakupów',
			'paid' => 'zapłacono',
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
		$criteria->compare('fabric_collection_fabric_id',$this->fabric_collection_fabric_id);
		$criteria->compare('article_amount',$this->article_amount,true);
		$criteria->compare('article_calculated_amount',$this->article_calculated_amount,true);
		$criteria->compare('shopping_term',$this->shopping_term,true);
		$criteria->compare('shopping_date_of_shipment',$this->shopping_date_of_shipment,true);
		$criteria->compare('shopping_delivery_date',$this->shopping_delivery_date,true);
		$criteria->compare('shopping_scheduled_delivery',$this->shopping_scheduled_delivery,true);
		$criteria->compare('article_delivered_amount',$this->article_delivered_amount,true);
		$criteria->compare('article_price',$this->article_price,true);
		$criteria->compare('document_name',$this->document_name,true);
		$criteria->compare('invoice_name',$this->invoice_name,true);
		$criteria->compare('shopping_notes',$this->shopping_notes,true);
		$criteria->compare('shopping_printed',$this->shopping_printed,true);
		$criteria->compare('creation_time',$this->creation_time,true);
		if ($this->shopping_status == "w trakcie") {
			$criteria->addCondition('shopping_status not like :shopping_status and shopping_status not like :canceled');
			$criteria->params=array_merge($criteria->params,array(':shopping_status'=>'%dostarczono%', ':canceled'=>'%anulowan%'));
		} else {
			$criteria->compare('shopping_status',$this->shopping_status,true);
		}
		$criteria->compare('paid',$this->paid);
		
		$criteria->with=array('fabricCollectionFabric'=>array('with'=>'supplierSupplier', 'together'=>true));
		$criteria->together=true;
		$criteria->compare('fabricCollectionFabric.fabric_number',$this->textile_textile_number,true);
		$criteria->compare('fabricCollectionFabric.fabric_name',$this->textile_textile_name,true);
		$criteria->compare('supplierSupplier.supplier_name',$this->textile_supplier_supplier_name,true);
		
		//Create a new CSort
		$sort = new CSort;
		$sort->attributes = array(
				'fabricCollectionFabric.fabric_number',
				'fabricCollectionFabric.fabric_name',
				'supplierSupplier.supplier_name',
				'*',//Add the * to include all the rest of the fields from the main model
		);
		$sort->defaultOrder='shopping_number ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>200),
			'sort'=>$sort
			//'sort'=>array('defaultOrder'=>'shopping_number ASC')
		));
	}
	
	public function beforeValidate() {
		$this->shopping_type='textil';
			
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
