<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs=array(
	'Suppliers'=>array('index'),
	$model->supplier_id=>array('view','id'=>$model->supplier_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Supplier', 'url'=>array('index')),
	array('label'=>'Create Supplier', 'url'=>array('create')),
	array('label'=>'View Supplier', 'url'=>array('view', 'id'=>$model->supplier_id)),
	array('label'=>'Manage Supplier', 'url'=>array('admin')),
);
?>

<h1>Update Supplier <?php echo $model->supplier_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>