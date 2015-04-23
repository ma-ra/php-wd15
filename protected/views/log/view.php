<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->log_id,
);

$this->menu=array(
	array('label'=>'List Log', 'url'=>array('index')),
	array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'Update Log', 'url'=>array('update', 'id'=>$model->log_id)),
	array('label'=>'Delete Log', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->log_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

<h1>View Log #<?php echo $model->log_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'log_id',
		'creation_time',
		'user_id',
		'user_name',
		'route',
		'actionaction',
		'params',
		'info',
	),
)); ?>
