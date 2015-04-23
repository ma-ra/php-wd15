<?php
/* @var $this LogController */
/* @var $model Log */

$this->breadcrumbs=array(
	'Logs'=>array('index'),
	$model->log_id=>array('view','id'=>$model->log_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Log', 'url'=>array('index')),
	array('label'=>'Create Log', 'url'=>array('create')),
	array('label'=>'View Log', 'url'=>array('view', 'id'=>$model->log_id)),
	array('label'=>'Manage Log', 'url'=>array('admin')),
);
?>

<h1>Update Log <?php echo $model->log_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>