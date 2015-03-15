<?php
/* @var $this BrokerController */
/* @var $model Broker */

$this->breadcrumbs=array(
	'Brokers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Broker', 'url'=>array('index')),
	array('label'=>'Manage Broker', 'url'=>array('admin')),
);
?>

<h1>Create Broker</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>