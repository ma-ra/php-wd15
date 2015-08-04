<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->breadcrumbs=array(
	'Shoppings'=>array('index'),
	$model->shopping_id,
);

$this->menu=array(
	array('label'=>'List Shopping', 'url'=>array('index')),
	array('label'=>'Create Shopping', 'url'=>array('create')),
	array('label'=>'Update Shopping', 'url'=>array('update', 'id'=>$model->shopping_id)),
	array('label'=>'Delete Shopping', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->shopping_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shopping', 'url'=>array('admin')),
);
?>

<h1>View Shopping #<?php echo $model->shopping_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'shopping_id',
		'shopping_number',
		'shopping_type',
		'textile_textile_id',
		'article_amount',
		'article_calculated_amount',
		'shopping_term',
		'shopping_date_of_shipment',
		'shopping_scheduled_delivery',
		'shopping_notes',
		'shopping_status',
		'shopping_printed',
		'creation_time',
	),
)); ?>
