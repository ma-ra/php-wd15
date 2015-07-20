<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
	$model->order_id,
);

$this->menu=array(
	array('label'=>'Dodaj zamówienie', 'url'=>array('create')),
	array('label'=>'Modyfikuj zamówienie', 'url'=>array('update', 'id'=>$model->order_id)),
	array('label'=>'Usuń zamówienie', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id),'confirm'=>'Czy na pewno usunąć ten element?')),
	array('label'=>'Lista zamówień', 'url'=>array('admin')),
);
?>

<h1>Szczegóły #<?php echo $model->order_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		'order_number',
		'order_date',
		'buyer_order_number',
		'buyer_comments',
		'order_reference',
		'order_term',
		'article_amount',
		'buyer_buyer_id',
		'broker_broker_id',
		'manufacturer_manufacturer_id',
		'leg_leg_id',
		'article_article_id',
		'textil_pair',
		'textilpair_price_group',
		'textile1_textile_id',
		'textile2_textile_id',
		'order_price',
		'order_total_price',
		'shopping1_shopping_id',
		'shopping2_shopping_id',
		'printed_minilabel',
		'printed_shipping_label',
		'textile_prepared',
		'article_planed',
		'article_manufactured',
		'article_prepared_to_export',
		'article_exported',
		'article_canceled',
		'order_error',
		'order_add_date',
		'order_storno_date',
		'checked',
	),
)); ?>
