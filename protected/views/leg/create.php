<?php
/* @var $this LegController */
/* @var $model Leg */

$this->breadcrumbs=array(
	'Legs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Leg', 'url'=>array('index')),
	array('label'=>'Manage Leg', 'url'=>array('admin')),
);
?>

<h1>Create Leg</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>