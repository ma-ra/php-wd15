<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $order_id
 * @property string $order_number
 * @property string $order_date
 * @property string $buyer_order_number
 * @property string $buyer_comments
 * @property string $order_reference
 * @property string $order_term
 * @property integer $article_amount
 * @property integer $buyer_buyer_id
 * @property integer $broker_broker_id
 * @property integer $manufacturer_manufacturer_id
 * @property integer $leg_leg_id
 * @property integer $article_article_id
 * @property integer $textil_pair
 * @property integer $textilpair_price_group
 * @property integer $textile1_textile_id
 * @property integer $textile2_textile_id
 * @property string $order_price
 * @property string $order_total_price
 * @property integer $shopping1_shopping_id
 * @property integer $shopping2_shopping_id
 * @property string $printed_minilabel
 * @property string $printed_shipping_label
 * @property integer $textile_prepared
 * @property string $article_planed
 * @property integer $article_manufactured
 * @property integer $article_prepared_to_export
 * @property string $article_exported
 * @property integer $article_canceled
 * @property string $order_error
 * @property string $order_notes
 * @property string $order_add_date
 * @property string $order_storno_date
 * @property integer $checked
 *
 * The followings are the available model relations:
 * @property Buyer $buyerBuyer
 * @property Broker $brokerBroker
 * @property Manufacturer $manufacturerManufacturer
 * @property Leg $legLeg
 * @property Article $articleArticle
 * @property Textile $textile1Textile
 * @property Textile $textile2Textile
 * @property Shopping $shopping1Shopping
 * @property Shopping $shopping2Shopping
 */
class Order extends CActiveRecord
{
	
	public $manufacturerManufacturer_manufacturer_name;
	public $brokerBroker_broker_name;
	public $buyerBuyer_buyer_name_1;
	public $articleArticle_article_number;
	public $articleArticle_model_name;
	public $articleArticle_model_type;
	public $articleArticle_article_colli;
	public $articleArticle_article_all_textile_amount;
	public $articleArticle_price_in_pg1;
	public $articleArticle_price_in_pg2;
	public $articleArticle_price_in_pg3;
	public $articleArticle_price_in_pg4;
	public $articleArticle_price_in_pg5;
	public $articleArticle_price_in_pg6;
	public $articleArticle_price_in_pg7;
	public $legLeg_leg_type;
	public $textiles1_textile_number;
	public $textiles1_textile_name;
	public $textiles1_textile_price_groupe;
	public $textiles2_textile_number;
	public $textiles2_textile_name;
	public $textiles2_textile_price_groupe;
	public $fabrics_fabric_price_group;
	public $shopping1Shopping_shopping_status;
	public $shopping2Shopping_shopping_status;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_number, order_term, article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id, textile1_textile_id', 'required'),
			array('article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id,  textil_pair, textilpair_price_group, textile1_textile_id, textile2_textile_id, textile_prepared, article_manufactured, article_canceled, checked, shopping1_shopping_id, shopping2_shopping_id, article_prepared_to_export', 'numerical', 'integerOnly'=>true),
			array('order_number, buyer_order_number, order_term, article_exported, order_error, article_planed, order_notes', 'length', 'max'=>50),
			array('buyer_comments, order_reference', 'length', 'max'=>150),
			array('order_price, order_total_price', 'length', 'max'=>9),
			array('order_date, order_add_date, order_storno_date, printed_minilabel, printed_shipping_label', 'safe'),
			array('order_date, buyer_order_number, buyer_comments, order_reference, textil_pair, textilpair_price_group, textile2_textile_id, printed_minilabel, printed_shipping_label, article_exported, article_planed', 'default', 'setOnEmpty' => true, 'value' => null),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, order_number, order_date, buyer_order_number, buyer_comments, order_reference, order_term, article_amount, buyer_buyer_id, broker_broker_id, manufacturer_manufacturer_id, leg_leg_id, article_article_id, textil_pair, textilpair_price_group, textile1_textile_id, textile2_textile_id, printed_minilabel, printed_shipping_label, article_manufactured, article_exported, manufacturerManufacturer_manufacturer_name, brokerBroker_broker_name, buyerBuyer_buyer_name_1, articleArticle_article_number, articleArticle_model_name, articleArticle_model_type, articleArticle_article_colli, legLeg_leg_type, textiles1_textile_number, textiles1_textile_name, textiles1_textile_price_groupe, textiles2_textile_number, textiles2_textile_name, textiles2_textile_price_group, textile1_textile_id, textile2_textile_id, checked, shopping1_shopping_id, shopping2_shopping_id, article_planed, article_prepared_to_export, shopping1Shopping_shopping_status, shopping2Shopping_shopping_status, order_price, order_total_price, order_storno_date, article_planed, order_notes', 'safe', 'on'=>'search'),
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
			'buyerBuyer' => array(self::BELONGS_TO, 'Buyer', 'buyer_buyer_id'),
			'brokerBroker' => array(self::BELONGS_TO, 'Broker', 'broker_broker_id'),
			'manufacturerManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_manufacturer_id'),
			'legLeg' => array(self::BELONGS_TO, 'Leg', 'leg_leg_id'),
			'articleArticle' => array(self::BELONGS_TO, 'Article', 'article_article_id'),
			'textile1Textile' => array(self::BELONGS_TO, 'Textile', 'textile1_textile_id'),
			'textile2Textile' => array(self::BELONGS_TO, 'Textile', 'textile2_textile_id'),
			'shopping1Shopping' => array(self::BELONGS_TO, 'Shopping', 'shopping1_shopping_id'),
			'shopping2Shopping' => array(self::BELONGS_TO, 'Shopping', 'shopping2_shopping_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'id',
			'order_number' => 'nr',
			'order_date' => 'data zamówienia',
			'buyer_order_number' => 'nr. zam. klienta',
			'buyer_comments' => 'uwagi klienta',
			'order_reference' => 'referencje',
			'order_term' => 'termin',
			'article_amount' => 'liczba sztuk',
			'buyer_buyer_id' => 'id kupującego',
			'broker_broker_id' => 'id pośrednika',
			'manufacturer_manufacturer_id' => 'id producenta',
			'leg_leg_id' => 'id nogi',
			'article_article_id' => 'id artykułu',
			'textil_pair' => 'numer pary desenii',
			'textilpair_price_group' => 'grupa cenowa pary desenii',
			'textile1_textile_id' => 'id materiału 1',
			'textile2_textile_id' => 'id materiału 2',
			'order_price' => 'cena jedn.',
			'order_total_price' => 'cena całości',
			'printed_minilabel' => 'mini etykieta',
			'printed_shipping_label' => 'etykieta transportowa',
			'textile_prepared' => 'wykrojono',
			'article_manufactured' => 'wyprodukowano',
			'article_exported' => 'wywieziono',
			'article_canceled' => 'storno',
			'order_error' => 'błąd',
			'order_notes' => 'notatki',
			'order_add_date' => 'data wgrania',
			'order_storno_date' => 'data aktualizacji',
			'checked' => '&nbsp&nbsp&nbsp&nbsp',
			'shopping1_shopping_id' => 'id zakupów 1',
			'shopping2_shopping_id' => 'id zakupów 2',
			'article_planed' => 'zaplanowano na',
			'article_prepared_to_export' => 'załadowano',
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

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('order_number',$this->order_number,true);
		$criteria->compare('order_date',$this->order_date,true);
		$criteria->compare('buyer_order_number',$this->buyer_order_number,true);
		$criteria->compare('buyer_comments',$this->buyer_comments,true);
		$criteria->compare('order_reference',$this->order_reference,true);
		$criteria->compare('order_term',$this->order_term,true);
		$criteria->compare('t.article_amount',$this->article_amount);
		$criteria->compare('buyer_buyer_id',$this->buyer_buyer_id);
		$criteria->compare('broker_broker_id',$this->broker_broker_id);
		$criteria->compare('manufacturer_manufacturer_id',$this->manufacturer_manufacturer_id);
		$criteria->compare('leg_leg_id',$this->leg_leg_id);
		$criteria->compare('article_article_id',$this->article_article_id);
		$criteria->compare('textil_pair',$this->textil_pair);
		$criteria->compare('textilpair_price_group',$this->textilpair_price_group);
		$criteria->compare('textile1_textile_id',$this->textile1_textile_id);
		$criteria->compare('textile2_textile_id',$this->textile2_textile_id);
		$criteria->compare('order_price',$this->order_price,true);
		$criteria->compare('order_total_price',$this->order_total_price,true);
		if ($this->article_planed == "0") {
			$criteria->addCondition('article_planed is :article_planed' );
			$criteria->params=array_merge($criteria->params,array(':article_planed'=>null));
		} else {
			$criteria->compare('article_planed',$this->article_planed,true);
		}
		$criteria->compare('article_prepared_to_export',$this->article_prepared_to_export);
		if ($this->printed_minilabel == "0") {
			$criteria->addCondition('printed_minilabel is :printed_minilabel' );
			$criteria->params=array_merge($criteria->params,array(':printed_minilabel'=>null));
		} else {
			$criteria->compare('printed_minilabel',$this->printed_minilabel,true);
		}
		if ($this->printed_shipping_label == "0") {
			$criteria->addCondition('printed_shipping_label is :printed_shipping_label' );
			$criteria->params=array_merge($criteria->params,array(':printed_shipping_label'=>null));
		} else {
			$criteria->compare('printed_shipping_label',$this->printed_shipping_label,true);
		}
		$criteria->compare('textile_prepared',$this->textile_prepared);
		$criteria->compare('article_manufactured',$this->article_manufactured);
		if ($this->article_exported == "0") {
			$criteria->addCondition('article_exported is :article_exported' );
			$criteria->params=array_merge($criteria->params,array(':article_exported'=>null));
		} else {
			$criteria->compare('article_exported',$this->article_exported,true);
		}
		$criteria->compare('article_canceled',$this->article_canceled);
		$criteria->compare('order_error',$this->order_error,true);
		$criteria->compare('order_notes',$this->order_notes,true);
		$criteria->compare('order_add_date',$this->order_add_date,true);
		$criteria->compare('order_storno_date',$this->order_storno_date,true);
		$criteria->compare('checked',$this->checked);
		
		$criteria->with = array('manufacturerManufacturer', 'brokerBroker', 'buyerBuyer', 'articleArticle', 'legLeg', 'textile1Textile', 'textile2Textile', 'shopping1Shopping', 'shopping2Shopping');
		$criteria->together=true;
		
		$criteria->compare('manufacturerManufacturer.manufacturer_name',$this->manufacturerManufacturer_manufacturer_name,true);
		$criteria->compare('brokerBroker.broker_name',$this->brokerBroker_broker_name,true);
		$criteria->compare('buyerBuyer.buyer_name_1',$this->buyerBuyer_buyer_name_1,true);
		$criteria->compare('articleArticle.article_number',$this->articleArticle_article_number,true);
		$criteria->compare('articleArticle.model_name',$this->articleArticle_model_name,true);
		$criteria->compare('articleArticle.model_type',$this->articleArticle_model_type,true);
		$criteria->compare('articleArticle.article_colli',$this->articleArticle_article_colli,true);
		$criteria->compare('legLeg.leg_type',$this->legLeg_leg_type,true);
		$criteria->compare('textile1Textile.textile_number',$this->textiles1_textile_number,true);
		$criteria->compare('textile1Textile.textile_name',$this->textiles1_textile_name,true);
		$criteria->compare('textile1Textile.textile_price_group',$this->textiles1_textile_price_groupe,true);
		$criteria->compare('textile2Textile.textile_number',$this->textiles2_textile_number,true);
		$criteria->compare('textile2Textile.textile_name',$this->textiles2_textile_name,true);
		$criteria->compare('textile2Textile.textile_price_group',$this->textiles2_textile_price_groupe,true);
		if ($this->shopping1Shopping_shopping_status == "w trakcie") {
			$criteria->addCondition('shopping1Shopping.shopping_status not like :shopping1Shopping_shopping_status' );
			$criteria->params=array_merge($criteria->params,array(':shopping1Shopping_shopping_status'=>'%dostarczono%'));
		} else if ($this->shopping1Shopping_shopping_status == "0") {
			$criteria->addCondition('shopping1Shopping.shopping_status is :shopping1Shopping_shopping_status' );
			$criteria->params=array_merge($criteria->params,array(':shopping1Shopping_shopping_status'=>null));
		} else {
			$criteria->compare('shopping1Shopping.shopping_status',$this->shopping1Shopping_shopping_status,true);
		}
		if ($this->shopping2Shopping_shopping_status == "w trakcie") {
			$criteria->addCondition('shopping2Shopping.shopping_status not like :shopping2Shopping_shopping_status' );
			$criteria->params=array_merge($criteria->params,array(':shopping2Shopping_shopping_status'=>'%dostarczono%'));
		} else if ($this->shopping2Shopping_shopping_status == "0") {
			$criteria->addCondition('shopping2Shopping.shopping_status is :shopping2Shopping_shopping_status' );
			$criteria->params=array_merge($criteria->params,array(':shopping2Shopping_shopping_status'=>null));
		} else {
			$criteria->compare('shopping2Shopping.shopping_status',$this->shopping2Shopping_shopping_status,true);
		}
		
		//Create a new CSort
		$sort = new CSort;
		$sort->attributes = array(
				'manufacturerManufacturer.manufacturer_name',
				'brokerBroker.broker_name',
				'buyerBuyer.buyer_name_1',
				'articleArticle.article_number',
				'articleArticle.model_name',
				'articleArticle.model_type',
				'articleArticle.article_colli',
				'legLeg.leg_type',
				'textile1Textile.textile_number',
				'textile1Textile.textile_name',
				'textile1Textile.textile_price_group',
				'textile2Textile.textile_number',
				'textile2Textile.textile_name',
				'textile2Textile.textile_price_group',
				'shopping1Shopping.shopping_status',
				'shopping2Shopping.shopping_status',
				'*',//Add the * to include all the rest of the fields from the main model
		);
		//$sort->multiSort=true;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>800),
			'sort'=>$sort,
		));
	}
	
	public function beforeSave() {
		#wyprodukowano != 100% => zgłoś błąd, w przeciwnym wypadku usuń potencjalny bład
		if ($this->article_manufactured != $this->article_amount * $this->articleArticle->article_colli && $this->article_manufactured != 0) {
			$error=explode("|", $this->order_error);
			if (!in_array("not all", $error)) {
				array_push ( $error , "not all");
			}
			$error=implode("|", $error);
			$this->order_error=$error;
		} else {
			$error=explode("|", $this->order_error);
			if (in_array("not all", $error)) {
				$error = array_diff($error, array("not all"));
			}
			$error=implode("|", $error);
			$this->order_error=$error;
		}
		
		#kasowanie błędu storno (nie kasujmy podczas wgrywania)
		$error=explode("|", $this->order_error);
		if ($this->scenario !== 'upload' && in_array("storno", $error) && $this->article_canceled == 1) {
			$error = array_diff($error, array("storno"));
			$error=implode("|", $error);
			$this->order_error=$error;
		}
			
		return parent::beforeSave();
	}
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
