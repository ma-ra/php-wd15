<?php
/* @var $this ForReuseController */
/* @var $model ForReuse */

$this->breadcrumbs=array(
	'For Reuses'=>array('index'),
	$model->for_reuse_id=>array('view','id'=>$model->for_reuse_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ForReuse', 'url'=>array('index')),
	array('label'=>'Create ForReuse', 'url'=>array('create')),
	array('label'=>'View ForReuse', 'url'=>array('view', 'id'=>$model->for_reuse_id)),
	array('label'=>'Manage ForReuse', 'url'=>array('admin')),
);
?>

<h1>Update ForReuse <?php echo $model->for_reuse_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>