<?php
/* @var $this ForReuseController */
/* @var $model ForReuse */

$this->breadcrumbs=array(
	'For Reuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ForReuse', 'url'=>array('index')),
	array('label'=>'Manage ForReuse', 'url'=>array('admin')),
);
?>

<h1>Create ForReuse</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>