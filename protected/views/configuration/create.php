<?php
/* @var $this ConfigurationController */
/* @var $model Configuration */

$this->breadcrumbs=array(
	'Configurations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Configuration', 'url'=>array('index')),
	array('label'=>'Manage Configuration', 'url'=>array('admin')),
);
?>

<h1>Create Configuration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>