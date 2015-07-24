<?php
/* @var $this ForReuseController */
/* @var $model ForReuse */

$this->breadcrumbs=array(
	'For Reuses'=>array('index'),
	$model->for_reuse_id,
);

$this->menu=array(
	array('label'=>'List ForReuse', 'url'=>array('index')),
	array('label'=>'Create ForReuse', 'url'=>array('create')),
	array('label'=>'Update ForReuse', 'url'=>array('update', 'id'=>$model->for_reuse_id)),
	array('label'=>'Delete ForReuse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->for_reuse_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ForReuse', 'url'=>array('admin')),
);
?>

<h1>View ForReuse #<?php echo $model->for_reuse_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'for_reuse_id',
		'order_number',
		'article_number',
		'textile1_number',
		'textile2_number',
	),
)); ?>
