<?php

/**
 * This is the model class for table "manufacturer".
 *
 * The followings are the available columns in table 'manufacturer':
 * @property integer $manufacturer_id
 * @property string $manufacturer_number
 * @property string $manufacturer_name
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Manufacturer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'manufacturer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('manufacturer_number, manufacturer_name', 'required'),
			array('manufacturer_number', 'length', 'max'=>50),
			array('manufacturer_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('manufacturer_id, manufacturer_number, manufacturer_name', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'manufacturer_manufacturer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'manufacturer_id' => 'id producenta',
			'manufacturer_number' => 'numer producenta',
			'manufacturer_name' => 'nazwa producenta',
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

		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('manufacturer_number',$this->manufacturer_number,true);
		$criteria->compare('manufacturer_name',$this->manufacturer_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Manufacturer::model()->find(array(
		'condition'=>'manufacturer_name=:name AND manufacturer_number=:number',
		'params'=>array(':name'=>$this->manufacturer_name,
						':number'=>$this->manufacturer_number,
						),
		#ostatni element
		'order' => "manufacturer_id DESC",
		'limit' => 1
		));
		if (!empty($find)) {
			#update
			$this->manufacturer_id=$find->manufacturer_id;
		} else {
			return parent::beforeSave();
		}
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Manufacturer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
