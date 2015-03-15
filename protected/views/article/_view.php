<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_number')); ?>:</b>
	<?php echo CHtml::encode($data->article_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_name')); ?>:</b>
	<?php echo CHtml::encode($data->model_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_type')); ?>:</b>
	<?php echo CHtml::encode($data->model_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_colli')); ?>:</b>
	<?php echo CHtml::encode($data->article_colli); ?>
	<br />


</div>