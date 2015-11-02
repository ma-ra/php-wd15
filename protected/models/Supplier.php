<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $supplier_id
 * @property string $supplier_name
 * @property string $supplier_tel
 * @property string $supplier_email
 * @property string $bank_account
 * @property string $supplier_lang
 *
 * The followings are the available model relations:
 * @property FabricCollection[] $fabricCollections
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
			array('supplier_name, supplier_lang', 'required'),
			array('supplier_name', 'length', 'max'=>150),
			array('supplier_tel, supplier_email, supplier_lang', 'length', 'max'=>45),
			array('supplier_tel, supplier_email', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('supplier_id, supplier_name, supplier_tel, supplier_email, bank_account, supplier_lang', 'safe', 'on'=>'search'),
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
			'fabricCollections' => array(self::HAS_MANY, 'FabricCollection', 'supplier_supplier_id'),
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
			'bank_account' => 'nr konta bankowego',
			'supplier_lang' => 'język',
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
		$criteria->compare('bank_account',$this->bank_account,true);
		$criteria->compare('supplier_lang',$this->supplier_lang,true);

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
