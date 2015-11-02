<?php
/* @var $this FabricCollectionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fabric Collections',
);

$this->menu=array(
	array('label'=>'Create FabricCollection', 'url'=>array('create')),
	array('label'=>'Manage FabricCollection', 'url'=>array('admin')),
);
?>

<h1>Fabric Collections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
