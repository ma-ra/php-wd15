<?php
/* @var $this DeliveryAddressController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Delivery Addresses',
);

$this->menu=array(
	array('label'=>'Create DeliveryAddress', 'url'=>array('create')),
	array('label'=>'Manage DeliveryAddress', 'url'=>array('admin')),
);
?>

<h1>Delivery Addresses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
