<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->order_id,
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->order_id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->order_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->order_id; ?></h1>

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
		'textile_order',
		'printed_minilabel',
		'printed_shipping_label',
		'article_manufactured',
		'article_exported',
	),
)); ?>
