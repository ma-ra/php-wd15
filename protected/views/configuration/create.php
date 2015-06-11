<?php
/* @var $this ConfigurationController */
/* @var $model Configuration */

$this->breadcrumbs=array(
	'Lista parametrów'=>array('admin'),
	'Dodaj',
);

$this->menu=array(
	array('label'=>'Lista parametrów', 'url'=>array('admin')),
);
?>

<h1>Dodaj</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>