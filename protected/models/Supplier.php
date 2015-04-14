<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $supplier_id
 * @property string $supplier_name
 * @property string $supplier_tel
 * @property string $supplier_email
 * @property integer $textile_textile_id
 *
 * The followings are the available model relations:
 * @property Textile $textileTextile
 */
class Supplier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name, textile_textile_id', 'required'),
			array('textile_textile_id', 'numerical', 'integerOnly'=>true),
			array('supplier_name', 'length', 'max'=>150),
			array('supplier_tel, supplier_email', 'length', 'max'=>45),
			array('supplier_tel, supplier_email', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('supplier_id, supplier_name, supplier_tel, supplier_email, textile_textile_id', 'safe', 'on'=>'search'),
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
			'textileTextile' => array(self::BELONGS_TO, 'Textile', 'textile_textile_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'supplier_id' => 'dostawca',
			'supplier_name' => 'nazwa dostawcy',
			'supplier_tel' => 'tel dostawcy',
			'supplier_email' => 'email dostawcy',
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

		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('supplier_tel',$this->supplier_tel,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('textile_textile_id',$this->textile_textile_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Supplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
