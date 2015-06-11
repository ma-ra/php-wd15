<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Lista artykułów'=>array('admin'),
	$model->article_id=>array('view','id'=>$model->article_id),
	'Modyfikuj',
);

$this->menu=array(
	array('label'=>'Dodaj artykuł', 'url'=>array('create')),
	array('label'=>'Podgląd artykułu', 'url'=>array('view', 'id'=>$model->article_id)),
	array('label'=>'Lista artykułów', 'url'=>array('admin')),
);
?>

<h1>Modyfikuj # <?php echo $model->article_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>