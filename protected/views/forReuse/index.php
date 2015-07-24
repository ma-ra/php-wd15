<?php
/* @var $this ForReuseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'For Reuses',
);

$this->menu=array(
	array('label'=>'Create ForReuse', 'url'=>array('create')),
	array('label'=>'Manage ForReuse', 'url'=>array('admin')),
);
?>

<h1>For Reuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
