<?php

/**
 * This is the model class for table "rap_textile2".
 *
 * The followings are the available columns in table 'rap_textile2':
 * @property string $supplier_name
 * @property string $textile_number
 * @property string $textile_name
 * @property integer $order1_id
 * @property string $order1_number
 * @property integer $order1_checked
 * @property integer $order2_id
 * @property string $order2_number
 * @property integer $order2_checked
 * @property string $textile1_selected
 * @property string $textile2_selected
 * @property string $textiles_selected
 * @property string $textile1_warehouse
 * @property string $textiles_ordered
 * @property string $textile_yet_need
 */
class RapTextile2 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rap_textile2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('textile_number, textile_name', 'required'),
			array('order1_id, order1_checked, order2_id, order2_checked', 'numerical', 'integerOnly'=>true),
			array('supplier_name, textile_name', 'length', 'max'=>150),
			array('textile_number, order1_number, order2_number', 'length', 'max'=>50),
			array('textile1_selected, textile2_selected', 'length', 'max'=>19),
			array('textiles_selected', 'length', 'max'=>20),
			array('textile1_warehouse, textiles_ordered', 'length', 'max'=>31),
			array('textile_yet_need', 'length', 'max'=>33),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('supplier_name, textile_number, textile_name, order1_id, order1_number, order1_checked, order2_id, order2_number, order2_checked, textile1_selected, textile2_selected, textiles_selected, textile1_warehouse, textiles_ordered, textile_yet_need', 'safe', 'on'=>'search'),
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
			'supplier_name' => 'dostawca',
			'textile_number' => 'nr mat.',
			'textile_name' => 'nazwa mat.',
			'order1_id' => 'id zam. 1',
			'order1_number' => 'nr zam. 1',
			'order1_checked' => 'zazn. na zam. 1',
			'order2_id' => 'id zam. 2',
			'order2_number' => 'nr zam. 2',
			'order2_checked' => 'zazn. na zam. 2',
			'textile1_selected' => 'mat. 1 dla zazn.',
			'textile2_selected' => 'mat. 2 dla zazn.',
			'textiles_selected' => 'mat. dla zazn',
			'textile1_warehouse' => 'na magazynie',
			'textiles_ordered' => 'zamówione',
			'textile_yet_need' => 'jeszcze potrzeba',
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

		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('textile_number',$this->textile_number,true);
		$criteria->compare('textile_name',$this->textile_name,true);
		$criteria->compare('order1_id',$this->order1_id);
		$criteria->compare('order1_number',$this->order1_number,true);
		$criteria->compare('order1_checked',$this->order1_checked);
		$criteria->compare('order2_id',$this->order2_id);
		$criteria->compare('order2_number',$this->order2_number,true);
		$criteria->compare('order2_checked',$this->order2_checked);
		$criteria->compare('textile1_selected',$this->textile1_selected,true);
		$criteria->compare('textile2_selected',$this->textile2_selected,true);
		$criteria->compare('textiles_selected',$this->textiles_selected,true);
		$criteria->compare('textile1_warehouse',$this->textile1_warehouse,true);
		$criteria->compare('textiles_ordered',$this->textiles_ordered,true);
		$criteria->compare('textile_yet_need',$this->textile_yet_need,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RapTextile2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
