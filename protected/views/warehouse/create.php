<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs=array(
	'Warehouses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Warehouse', 'url'=>array('index')),
	array('label'=>'Manage Warehouse', 'url'=>array('admin')),
);
?>

<h1>Create Warehouse</h1>

<?php $this->renderPartial('_form_create', array('models'=>$models)); ?>