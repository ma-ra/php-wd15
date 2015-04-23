<?php
/* @var $this ShoppingController */
/* @var $model Shopping */

$this->breadcrumbs=array(
	'Shoppings'=>array('index'),
	$model->shopping_id=>array('view','id'=>$model->shopping_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Shopping', 'url'=>array('index')),
	array('label'=>'Create Shopping', 'url'=>array('create')),
	array('label'=>'View Shopping', 'url'=>array('view', 'id'=>$model->shopping_id)),
	array('label'=>'Manage Shopping', 'url'=>array('admin')),
);
?>

<h1>Update Shopping <?php echo $model->shopping_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>