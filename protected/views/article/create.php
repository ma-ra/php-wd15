<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Lista artykułów'=>array('admin'),
	'Dodaj',
);

$this->menu=array(
	array('label'=>'Lista artykułów', 'url'=>array('admin')),
);
?>

<h1>Dodaj artykuł</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>