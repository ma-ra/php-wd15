<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Lista artykułów'=>array('admin')
);

?>

<h1>Lista artykułów</h1>
<p>W przypadku pojawienia się nowych artykułów należy uzupełnić liczbę "colli" oraz rozkładkę materiału.</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'article_id',
		'article_number',
		'model_name',
		'model_type',
		'article_colli',
		'article_all_textile_amount',
		'article_first_textile_amount',
		'article_second_textile_amount',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
