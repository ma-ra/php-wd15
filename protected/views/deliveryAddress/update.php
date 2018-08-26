``<?php
/* @var $this DeliveryAddressController */
/* @var $model DeliveryAddress */

$this->breadcrumbs=array(
	'Delivery Addresses'=>array('index'),
	$model->delivery_address_id=>array('view','id'=>$model->delivery_address_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DeliveryAddress', 'url'=>array('index')),
	array('label'=>'Create DeliveryAddress', 'url'=>array('create')),
	array('label'=>'View DeliveryAddress', 'url'=>array('view', 'id'=>$model->delivery_address_id)),
	array('label'=>'Manage DeliveryAddress', 'url'=>array('admin')),
);
?>

<h1>Update DeliveryAddress <?php echo $model->delivery_address_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>