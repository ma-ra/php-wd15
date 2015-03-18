<?php

/**
 * This is the model class for table "order_has_textile".
 *
 * The followings are the available columns in table 'order_has_textile':
 * @property integer $order_order_id
 * @property integer $textile_textile_id
 */
class OrderHasTextile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_has_textile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_order_id, textile_textile_id', 'required'),
			array('order_order_id, textile_textile_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_order_id, textile_textile_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_order_id' => 'id zamówienia',
			'textile_textile_id' => 'id materiału',
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

		$criteria->compare('order_order_id',$this->order_order_id);
		$criteria->compare('textile_textile_id',$this->textile_textile_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=OrderHasTextile::model()->find(array(
			'condition'=>'order_order_id=:order_order_id AND textile_textile_id=:textile_textile_id',
			'params'=>array(':order_order_id'=>$this->order_order_id, ':textile_textile_id'=>$this->textile_textile_id),
			#ostatni element
			'order' => "order_order_id",
			'limit' => 1
		));
		if (!empty($find)) {
			$this->order_order_id=$find->order_order_id;
			$this->textile_textile_id=$find->textile_textile_id;
		} else {
			return parent::beforeSave();
		}
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderHasTextile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
