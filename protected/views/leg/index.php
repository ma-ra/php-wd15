<?php
/* @var $this LegController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Legs',
);

$this->menu=array(
	array('label'=>'Create Leg', 'url'=>array('create')),
	array('label'=>'Manage Leg', 'url'=>array('admin')),
);
?>

<h1>Legs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
