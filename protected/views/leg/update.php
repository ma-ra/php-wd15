<?php
/* @var $this LegController */
/* @var $model Leg */

$this->breadcrumbs=array(
	'Legs'=>array('index'),
	$model->leg_id=>array('view','id'=>$model->leg_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Leg', 'url'=>array('index')),
	array('label'=>'Create Leg', 'url'=>array('create')),
	array('label'=>'View Leg', 'url'=>array('view', 'id'=>$model->leg_id)),
	array('label'=>'Manage Leg', 'url'=>array('admin')),
);
?>

<h1>Update Leg <?php echo $model->leg_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>