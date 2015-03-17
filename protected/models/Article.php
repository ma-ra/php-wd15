<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $article_id
 * @property string $article_number
 * @property string $model_name
 * @property string $model_type
 * @property integer $article_colli
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 */
class Article extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_number, model_name, model_type', 'required'),
			array('article_colli', 'numerical', 'integerOnly'=>true),
			array('article_number', 'length', 'max'=>50),
			array('model_name, model_type', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('article_id, article_number, model_name, model_type, article_colli', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'article_article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'article_id' => 'id artykułu',
			'article_number' => 'numer artykułu',
			'model_name' => 'model',
			'model_type' => 'typ',
			'article_colli' => 'colli',
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

		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('article_number',$this->article_number,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_type',$this->model_type,true);
		$criteria->compare('article_colli',$this->article_colli);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>50),
		));
	}
	
	public function beforeSave() {
		#wyszukujemy, czy taki wpis już istnieje
		$find=Article::model()->find(array(
		'condition'=>'article_number=:number AND model_name=:name AND model_type=:type',
		'params'=>array(':number'=>$this->article_number,
						':name'=>$this->model_name,
						':type'=>$this->model_type,
						),
		#ostatni element
		'order' => "article_id DESC",
		'limit' => 1
		));
		if (!empty($find)) {
			#update
			$this->article_id=$find->article_id;
		} else {
			return parent::beforeSave();
		}
	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
