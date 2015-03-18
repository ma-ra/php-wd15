<?php
/* @var $this ConfigurationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Configurations',
);

$this->menu=array(
	array('label'=>'Create Configuration', 'url'=>array('create')),
	array('label'=>'Manage Configuration', 'url'=>array('admin')),
);
?>

<h1>Configurations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
