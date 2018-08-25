<?php

/**
 * This is the model class for table "delivery_address".
 *
 * The followings are the available columns in table 'delivery_address':
 * @property integer $delivery_address_id
 * @property string $delivery_address_name_1
 * @property string $delivery_address_name_2
 * @property string $delivery_address_street
 * @property string $delivery_addressr_zip_code
 * @property string $delivery_addressr_city
 * @property string $delivery_addressr_contact
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class DeliveryAddress extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'delivery_address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('delivery_address_name_1, delivery_address_street, delivery_addressr_zip_code, delivery_addressr_city', 'required'),
			array('delivery_address_name_1, delivery_address_name_2, delivery_address_street, delivery_addressr_zip_code, delivery_addressr_city, delivery_addressr_contact', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('delivery_address_id, delivery_address_name_1, delivery_address_name_2, delivery_address_street, delivery_addressr_zip_code, delivery_addressr_city, delivery_addressr_contact', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'delivery_address_delivery_address_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'delivery_address_id' => 'id adresu dostawy',
			'delivery_address_name_1' => 'nazwa adresu dostawy',
			'delivery_address_name_2' => 'nazwa 2 adresu dostawy',
			'delivery_address_street' => 'ulica adresu dostawy',
			'delivery_addressr_zip_code' => 'kod adresu dostawy',
			'delivery_addressr_city' => 'miasto adresu dostawy',
			'delivery_addressr_contact' => 'kontakt adresu dostawy',
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

		$criteria->compare('delivery_address_id',$this->delivery_address_id);
		$criteria->compare('delivery_address_name_1',$this->delivery_address_name_1,true);
		$criteria->compare('delivery_address_name_2',$this->delivery_address_name_2,true);
		$criteria->compare('delivery_address_street',$this->delivery_address_street,true);
		$criteria->compare('delivery_addressr_zip_code',$this->delivery_addressr_zip_code,true);
		$criteria->compare('delivery_addressr_city',$this->delivery_addressr_city,true);
		$criteria->compare('delivery_addressr_contact',$this->delivery_addressr_contact,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DeliveryAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
