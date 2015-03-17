<?php

/**
 * This is the model class for table "leg".
 *
 * The followings are the available columns in table 'leg':
 * @property integer $leg_id
 * @property string $leg_type
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Leg extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'leg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leg_type', 'required'),
			array('leg_type', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('leg_id, leg_type', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'leg_leg_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'leg_id' => 'id nogi',
			'leg_type' => 'nogi',
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

		$criteria->compare('leg_id',$this->leg_id);
		$criteria->compare('leg_type',$this->leg_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Leg::model()->find(array(
		'condition'=>'leg_type=:leg',
		'params'=>array(':leg'=>$this->leg_type),
		#ostatni element
		'order' => "leg_id DESC",
		'limit' => 1
		));
		if (!empty($find)) {
			#update
			$this->leg_id=$find->leg_id;
		} else {
			return parent::beforeSave();
		}
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Leg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
