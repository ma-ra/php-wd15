<?php
/* @var $this ForReuseController */
/* @var $model ForReuse */

$this->breadcrumbs=array(
	'For Reuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ForReuse', 'url'=>array('index')),
	array('label'=>'Create ForReuse', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#for-reuse-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage For Reuses</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'for-reuse-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'for_reuse_id',
		'order_number',
		'article_number',
		'textile1_number',
		'textile2_number',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
