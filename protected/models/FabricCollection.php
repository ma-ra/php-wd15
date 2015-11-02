<?php

/**
 * This is the model class for table "fabric_collection".
 *
 * The followings are the available columns in table 'fabric_collection':
 * @property integer $fabric_id
 * @property string $fabric_number
 * @property string $fabric_name
 * @property integer $fabric_price_group
 * @property integer $supplier_supplier_id
 * @property string $fabric_price
 *
 * The followings are the available model relations:
 * @property Supplier $supplierSupplier
 * @property Shopping[] $shoppings
 * @property Textile[] $textiles
 */
class FabricCollection extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'fabric_collection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fabric_number, fabric_name, fabric_price_group, fabric_price', 'required'),
			array('fabric_price_group, supplier_supplier_id', 'numerical', 'integerOnly'=>true),
			array('fabric_number', 'length', 'max'=>50),
			array('fabric_name', 'length', 'max'=>150),
			array('fabric_price', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fabric_id, fabric_number, fabric_name, fabric_price_group, supplier_supplier_id, fabric_price', 'safe', 'on'=>'search'),
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
			'supplierSupplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_supplier_id'),
			'shoppings' => array(self::HAS_MANY, 'Shopping', 'fabric_collection_fabric_id'),
			'textiles' => array(self::HAS_MANY, 'Textile', 'textile_number'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fabric_id' => 'id materiału',
			'fabric_number' => 'numer materiału',
			'fabric_name' => 'nazwa materiału',
			'fabric_price_group' => 'grupa cenowa',
			'supplier_supplier_id' => 'id dostawcy',
			'fabric_price' => 'cena katalogowa',
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

		$criteria->compare('fabric_id',$this->fabric_id);
		$criteria->compare('fabric_number',$this->fabric_number,true);
		$criteria->compare('fabric_name',$this->fabric_name,true);
		$criteria->compare('fabric_price_group',$this->fabric_price_group);
		$criteria->compare('supplier_supplier_id',$this->supplier_supplier_id);
		$criteria->compare('fabric_price',$this->fabric_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>500),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FabricCollection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
