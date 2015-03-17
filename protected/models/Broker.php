<?php

/**
 * This is the model class for table "broker".
 *
 * The followings are the available columns in table 'broker':
 * @property integer $broker_id
 * @property string $broker_name
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Broker extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'broker';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('broker_name', 'required'),
			array('broker_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('broker_id, broker_name', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'broker_broker_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'broker_id' => 'id pośrednika',
			'broker_name' => 'nazwa',
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

		$criteria->compare('broker_id',$this->broker_id);
		$criteria->compare('broker_name',$this->broker_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Broker::model()->find(array(
		'condition'=>'broker_name=:name',
		'params'=>array(':name'=>$this->broker_name),
		#ostatni element
		'order' => "broker_id DESC",
		'limit' => 1
		));
		if (!empty($find)) {
			#update
			$this->broker_id=$find->broker_id;
		} else {
			return parent::beforeSave();
		}
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Broker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
