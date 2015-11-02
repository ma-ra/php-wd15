<?php
/* @var $this FabricCollectionController */
/* @var $model FabricCollection */

$this->breadcrumbs=array(
	'Fabric Collections'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FabricCollection', 'url'=>array('index')),
	array('label'=>'Manage FabricCollection', 'url'=>array('admin')),
);
?>

<h1>Create FabricCollection</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>