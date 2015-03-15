<?php
/* @var $this BrokerController */
/* @var $model Broker */

$this->breadcrumbs=array(
	'Brokers'=>array('index'),
	$model->broker_id,
);

$this->menu=array(
	array('label'=>'List Broker', 'url'=>array('index')),
	array('label'=>'Create Broker', 'url'=>array('create')),
	array('label'=>'Update Broker', 'url'=>array('update', 'id'=>$model->broker_id)),
	array('label'=>'Delete Broker', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->broker_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Broker', 'url'=>array('admin')),
);
?>

<h1>View Broker #<?php echo $model->broker_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'broker_id',
		'broker_name',
	),
)); ?>
