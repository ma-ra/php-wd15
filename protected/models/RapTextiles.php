<?php

/**
 * This is the model class for table "rap_textiles".
 *
 * The followings are the available columns in table 'rap_textiles':
 * @property string $supplier_name
 * @property string $textile_number
 * @property string $fabric_name
 * @property integer $order1_id
 * @property string $order1_number
 * @property integer $order1_checked
 * @property integer $order2_id
 * @property string $order2_number
 * @property integer $order2_checked
 * @property string $textile1_selected
 * @property string $textile2_selected
 * @property string $textiles_selected
 * @property string $textiles_ordered
 */
class RapTextiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rap_textiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('textile_number', 'required'),
			array('order1_id, order1_checked, order2_id, order2_checked', 'numerical', 'integerOnly'=>true),
			array('supplier_name, fabric_name', 'length', 'max'=>150),
			array('textile_number, order1_number, order2_number', 'length', 'max'=>50),
			array('textile1_selected, textile2_selected', 'length', 'max'=>19),
			array('textiles_selected', 'length', 'max'=>20),
			array('textiles_ordered', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('supplier_name, textile_number, fabric_name, order1_id, order1_number, order1_checked, order2_id, order2_number, order2_checked, textile1_selected, textile2_selected, textiles_selected, textiles_ordered', 'safe', 'on'=>'search'),
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
			'supplier_name' => 'Supplier Name',
			'textile_number' => 'Textile Number',
			'fabric_name' => 'Fabric Name',
			'order1_id' => 'Order1',
			'order1_number' => 'Order1 Number',
			'order1_checked' => 'Order1 Checked',
			'order2_id' => 'Order2',
			'order2_number' => 'Order2 Number',
			'order2_checked' => 'Order2 Checked',
			'textile1_selected' => 'Textile1 Selected',
			'textile2_selected' => 'Textile2 Selected',
			'textiles_selected' => 'Textiles Selected',
			'textiles_ordered' => 'Textiles Ordered',
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
		$criteria->compare('fabric_name',$this->fabric_name,true);
		$criteria->compare('order1_id',$this->order1_id);
		$criteria->compare('order1_number',$this->order1_number,true);
		$criteria->compare('order1_checked',$this->order1_checked);
		$criteria->compare('order2_id',$this->order2_id);
		$criteria->compare('order2_number',$this->order2_number,true);
		$criteria->compare('order2_checked',$this->order2_checked);
		$criteria->compare('textile1_selected',$this->textile1_selected,true);
		$criteria->compare('textile2_selected',$this->textile2_selected,true);
		$criteria->compare('textiles_selected',$this->textiles_selected,true);
		$criteria->compare('textiles_ordered',$this->textiles_ordered,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RapTextiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
