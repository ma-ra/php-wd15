<?php
/* @var $this ConfigurationController */
/* @var $model Configuration */

$this->breadcrumbs=array(
	'Lista parametrów'=>array('admin'),
	$model->name=>array('view','id'=>$model->name),
	'Modyfikuj',
);

$this->menu=array(
	array('label'=>'Dodaj parametr', 'url'=>array('create')),
	array('label'=>'Podgląd parametru', 'url'=>array('view', 'id'=>$model->name)),
	array('label'=>'Lista parametrów', 'url'=>array('admin')),
);
?>

<h1>Modyfikuj # <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>