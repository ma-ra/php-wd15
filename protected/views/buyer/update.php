<?php
/* @var $this BuyerController */
/* @var $model Buyer */

$this->breadcrumbs=array(
	'Buyers'=>array('index'),
	$model->buyer_id=>array('view','id'=>$model->buyer_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Buyer', 'url'=>array('index')),
	array('label'=>'Create Buyer', 'url'=>array('create')),
	array('label'=>'View Buyer', 'url'=>array('view', 'id'=>$model->buyer_id)),
	array('label'=>'Manage Buyer', 'url'=>array('admin')),
);
?>

<h1>Update Buyer <?php echo $model->buyer_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>