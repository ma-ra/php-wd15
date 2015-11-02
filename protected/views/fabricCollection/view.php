<?php
/* @var $this FabricCollectionController */
/* @var $model FabricCollection */

$this->breadcrumbs=array(
	'Fabric Collections'=>array('index'),
	$model->fabric_id,
);

$this->menu=array(
	array('label'=>'List FabricCollection', 'url'=>array('index')),
	array('label'=>'Create FabricCollection', 'url'=>array('create')),
	array('label'=>'Update FabricCollection', 'url'=>array('update', 'id'=>$model->fabric_id)),
	array('label'=>'Delete FabricCollection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->fabric_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FabricCollection', 'url'=>array('admin')),
);
?>

<h1>View FabricCollection #<?php echo $model->fabric_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fabric_id',
		'fabric_number',
		'fabric_name',
		'fabric_price_group',
		'supplier_supplier_id',
		'fabric_price',
	),
)); ?>
