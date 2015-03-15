<?php
/* @var $this TextileController */
/* @var $model Textile */

$this->breadcrumbs=array(
	'Textiles'=>array('index'),
	$model->textile_id=>array('view','id'=>$model->textile_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Textile', 'url'=>array('index')),
	array('label'=>'Create Textile', 'url'=>array('create')),
	array('label'=>'View Textile', 'url'=>array('view', 'id'=>$model->textile_id)),
	array('label'=>'Manage Textile', 'url'=>array('admin')),
);
?>

<h1>Update Textile <?php echo $model->textile_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>