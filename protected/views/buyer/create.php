<?php
/* @var $this BuyerController */
/* @var $model Buyer */

$this->breadcrumbs=array(
	'Buyers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Buyer', 'url'=>array('index')),
	array('label'=>'Manage Buyer', 'url'=>array('admin')),
);
?>

<h1>Create Buyer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>