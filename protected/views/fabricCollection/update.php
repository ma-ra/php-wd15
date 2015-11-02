<?php
/* @var $this FabricCollectionController */
/* @var $model FabricCollection */

$this->breadcrumbs=array(
	'Fabric Collections'=>array('index'),
	$model->fabric_id=>array('view','id'=>$model->fabric_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FabricCollection', 'url'=>array('index')),
	array('label'=>'Create FabricCollection', 'url'=>array('create')),
	array('label'=>'View FabricCollection', 'url'=>array('view', 'id'=>$model->fabric_id)),
	array('label'=>'Manage FabricCollection', 'url'=>array('admin')),
);
?>

<h1>Update FabricCollection <?php echo $model->fabric_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>