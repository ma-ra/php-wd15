<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
	'Dodaj',
);

$this->menu=array(
	array('label'=>'Lista zamówień', 'url'=>array('admin')),
);
?>

<h1>Dodaj zamówienie</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>