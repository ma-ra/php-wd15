<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Lista artykułów'=>array('admin'),
	$model->article_id,
);

$this->menu=array(
	array('label'=>'Dodaj artykuł', 'url'=>array('create')),
	array('label'=>'Modyfikuj artykuł', 'url'=>array('update', 'id'=>$model->article_id)),
	array('label'=>'Usuń artykuł', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->article_id),'confirm'=>'Czy na pewno usunąć ten element?')),
	array('label'=>'Lista artykułów', 'url'=>array('admin')),
);
?>

<h1>Szczegóły #<?php echo $model->article_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'article_id',
		'article_number',
		'model_name',
		'model_type',
		'article_colli',
		'article_all_textile_amount',
		'article_first_textile_amount',
		'article_second_textile_amount',
		'price_in_pg1',
		'price_in_pg2',
		'price_in_pg3',
		'price_in_pg4',
		'price_in_pg5',
		'price_in_pg6',
		'price_in_pg7',
	),
)); ?>
