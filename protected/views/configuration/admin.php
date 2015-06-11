<?php
/* @var $this ConfigurationController */
/* @var $model Configuration */

$this->breadcrumbs=array(
	'Lista parametrów'=>array('admin'),
);

$this->menu=array(
	array('label'=>'Dodaj parametr', 'url'=>array('create')),
	array('label'=>'Kasuj bazę danych', 'url'=>array('truncate','noArticle'=>'false')),
	array('label'=>'Kasuj bazę danych za wyjątkiem artykułów', 'url'=>array('truncate','noArticle'=>'true')),
);
?>

<h1>Lista parametrów</h1>

<p>
Nie zmieniać nazw parametrów, tylko same wartości !!!.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'configuration-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
				'name' => 'value',
				'type' => 'raw',
				'value' => 'CHtml::link(CHtml::encode($data->value),array(\'configuration/update\',\'id\'=>$data->name))'
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
