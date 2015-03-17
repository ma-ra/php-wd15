<?php

/**
 * This is the model class for table "textile".
 *
 * The followings are the available columns in table 'textile':
 * @property integer $textile_id
 * @property string $textile_number
 * @property string $textile_name
 * @property integer $textile_price_group
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property Supplier[] $suppliers
 */
class Textile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'textile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('textile_number, textile_name, textile_price_group', 'required'),
			array('textile_price_group', 'numerical', 'integerOnly'=>true),
			array('textile_number', 'length', 'max'=>50),
			array('textile_name', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('textile_id, textile_number, textile_name, textile_price_group', 'safe', 'on'=>'search'),
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
			'orders' => array(self::MANY_MANY, 'Order', 'order_has_textile(textile_textile_id, order_order_id)'),
			'suppliers' => array(self::HAS_MANY, 'Supplier', 'textile_textile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'textile_id' => 'id materiału',
			'textile_number' => 'numer materiału',
			'textile_name' => 'nazwa materiału',
			'textile_price_group' => 'grupa cenowa',
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

		$criteria->compare('textile_id',$this->textile_id);
		$criteria->compare('textile_number',$this->textile_number,true);
		$criteria->compare('textile_name',$this->textile_name,true);
		$criteria->compare('textile_price_group',$this->textile_price_group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Textile::model()->find(array(
		'condition'=>'textile_number=:number AND textile_name=:name AND textile_price_group=:group',
		'params'=>array(':number'=>$this->textile_number,
						':name'=>$this->textile_name,
						':group'=>$this->textile_price_group,
						),
		#ostatni element
		'order' => "textile_id DESC",
		'limit' => 1
		));
		if (!empty($find)) {
			#update
			$this->textile_id=$find->textile_id;
		} else {
			return parent::beforeSave();
		}
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Textile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
