<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs=array(
	'Warehouses'=>array('index'),
	$model->warehouse_id,
);

$this->menu=array(
	array('label'=>'List Warehouse', 'url'=>array('index')),
	array('label'=>'Create Warehouse', 'url'=>array('create')),
	array('label'=>'Update Warehouse', 'url'=>array('update', 'id'=>$model->warehouse_id)),
	array('label'=>'Delete Warehouse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->warehouse_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Warehouse', 'url'=>array('admin')),
);
?>

<h1>View Warehouse #<?php echo $model->warehouse_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'warehouse_id',
		'warehouse_type',
		'article_name',
		'article_count',
		'article_price',
		'document_name',
		'warehouse_error',
		'shopping_shopping_id',
		'creation_date',
	),
)); ?>
