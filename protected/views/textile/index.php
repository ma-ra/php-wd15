<?php
/* @var $this TextileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Textiles',
);

$this->menu=array(
	array('label'=>'Create Textile', 'url'=>array('create')),
	array('label'=>'Manage Textile', 'url'=>array('admin')),
);
?>

<h1>Textiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
