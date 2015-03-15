<?php
/* @var $this LegController */
/* @var $model Leg */

$this->breadcrumbs=array(
	'Legs'=>array('index'),
	$model->leg_id,
);

$this->menu=array(
	array('label'=>'List Leg', 'url'=>array('index')),
	array('label'=>'Create Leg', 'url'=>array('create')),
	array('label'=>'Update Leg', 'url'=>array('update', 'id'=>$model->leg_id)),
	array('label'=>'Delete Leg', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->leg_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Leg', 'url'=>array('admin')),
);
?>

<h1>View Leg #<?php echo $model->leg_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'leg_id',
		'leg_type',
	),
)); ?>
