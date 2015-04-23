<?php
/* @var $this ShoppingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shoppings',
);

$this->menu=array(
	array('label'=>'Create Shopping', 'url'=>array('create')),
	array('label'=>'Manage Shopping', 'url'=>array('admin')),
);
?>

<h1>Shoppings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
