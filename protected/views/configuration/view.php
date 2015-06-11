<?php
/* @var $this ConfigurationController */
/* @var $model Configuration */

$this->breadcrumbs=array(
	'Lista parametrów'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Dodaj parametr', 'url'=>array('create')),
	array('label'=>'Modyfikuj parametr', 'url'=>array('update', 'id'=>$model->name)),
	array('label'=>'Usuń parametr', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Lista parametrów', 'url'=>array('admin')),
);
?>

<h1>Szczegóły # <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'value',
	),
)); ?>
