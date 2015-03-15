<?php
/* @var $this TextileController */
/* @var $model Textile */

$this->breadcrumbs=array(
	'Textiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Textile', 'url'=>array('index')),
	array('label'=>'Manage Textile', 'url'=>array('admin')),
);
?>

<h1>Create Textile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>