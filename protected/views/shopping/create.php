<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->breadcrumbs=array(
	'Shoppings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shopping', 'url'=>array('index')),
	array('label'=>'Manage Shopping', 'url'=>array('admin')),
);
?>

<h1>Create Shopping</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>