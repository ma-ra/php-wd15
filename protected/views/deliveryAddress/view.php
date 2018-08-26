<?php
/* @var $this DeliveryAddressController */
/* @var $model DeliveryAddress */

$this->breadcrumbs=array(
	'Delivery Addresses'=>array('index'),
	$model->delivery_address_id,
);

$this->menu=array(
	array('label'=>'List DeliveryAddress', 'url'=>array('index')),
	array('label'=>'Create DeliveryAddress', 'url'=>array('create')),
	array('label'=>'Update DeliveryAddress', 'url'=>array('update', 'id'=>$model->delivery_address_id)),
	array('label'=>'Delete DeliveryAddress', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->delivery_address_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DeliveryAddress', 'url'=>array('admin')),
);
?>

<h1>View DeliveryAddress #<?php echo $model->delivery_address_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'delivery_address_id',
		'delivery_address_name_1',
		'delivery_address_name_2',
		'delivery_address_street',
		'delivery_address_zip_code',
		'delivery_address_city',
		'delivery_address_contact',
	),
)); ?>
