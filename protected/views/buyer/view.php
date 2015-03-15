<?php
/* @var $this BuyerController */
/* @var $model Buyer */

$this->breadcrumbs=array(
	'Buyers'=>array('index'),
	$model->buyer_id,
);

$this->menu=array(
	array('label'=>'List Buyer', 'url'=>array('index')),
	array('label'=>'Create Buyer', 'url'=>array('create')),
	array('label'=>'Update Buyer', 'url'=>array('update', 'id'=>$model->buyer_id)),
	array('label'=>'Delete Buyer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->buyer_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Buyer', 'url'=>array('admin')),
);
?>

<h1>View Buyer #<?php echo $model->buyer_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'buyer_id',
		'buyer_name_1',
		'buyer_name_2',
		'buyer_street',
		'buyer_zip_code',
	),
)); ?>
