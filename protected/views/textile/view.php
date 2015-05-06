<?php
/* @var $this TextileController */
/* @var $model Textile */

$this->breadcrumbs=array(
	'Textiles'=>array('index'),
	$model->textile_id,
);

$this->menu=array(
	array('label'=>'List Textile', 'url'=>array('index')),
	array('label'=>'Create Textile', 'url'=>array('create')),
	array('label'=>'Update Textile', 'url'=>array('update', 'id'=>$model->textile_id)),
	array('label'=>'Delete Textile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->textile_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Textile', 'url'=>array('admin')),
);
?>

<h1>View Textile #<?php echo $model->textile_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'textile_id',
		'textile_number',
		'textile_name',
		'textile_price_group',
		'supplier_supplier_id',
	),
)); ?>
