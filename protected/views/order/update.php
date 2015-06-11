<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
	$model->order_id=>array('view','id'=>$model->order_id),
	'Modyfikuj',
);

$this->menu=array(
	array('label'=>'Dodaj zamówienie', 'url'=>array('create')),
	array('label'=>'Podgląd zamówienia', 'url'=>array('view', 'id'=>$model->order_id)),
	array('label'=>'Lista zamówień', 'url'=>array('admin')),
);
?>

<h1>Modyfikuj # <?php echo $model->order_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>