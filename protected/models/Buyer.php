<?php

/**
 * This is the model class for table "buyer".
 *
 * The followings are the available columns in table 'buyer':
 * @property integer $buyer_id
 * @property string $buyer_name_1
 * @property string $buyer_name_2
 * @property string $buyer_street
 * @property string $buyer_zip_code
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Buyer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'buyer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buyer_name_1, buyer_street, buyer_zip_code', 'required'),
			array('buyer_name_1, buyer_name_2, buyer_street, buyer_zip_code', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('buyer_id, buyer_name_1, buyer_name_2, buyer_street, buyer_zip_code', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'buyer_buyer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'buyer_id' => 'id klienta',
			'buyer_name_1' => 'nazwa kupującego',
			'buyer_name_2' => 'dodatkowa nazwa kupującego',
			'buyer_street' => 'ulica',
			'buyer_zip_code' => 'kod pocztowy',
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

		$criteria->compare('buyer_id',$this->buyer_id);
		$criteria->compare('buyer_name_1',$this->buyer_name_1,true);
		$criteria->compare('buyer_name_2',$this->buyer_name_2,true);
		$criteria->compare('buyer_street',$this->buyer_street,true);
		$criteria->compare('buyer_zip_code',$this->buyer_zip_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Buyer::model()->find(array(
				'condition'=>'buyer_name_1=:name1 AND buyer_name_2=:name2 AND buyer_street=:street AND buyer_zip_code=:zip_code',
				'params'=>array(':name1'=>$this->buyer_name_1, 
								':name2'=>$this->buyer_name_2,
				 				':street'=>$this->buyer_street,
								':zip_code'=>$this->buyer_zip_code,
								),
				#ostatni element
				'order' => "buyer_id DESC",
				'limit' => 1
		));
		if (!empty($find) && $this->scenario === 'upload') {
			#update
			$this->buyer_id=$find->buyer_id;
		} else {
			return parent::beforeSave();
		}
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Buyer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
