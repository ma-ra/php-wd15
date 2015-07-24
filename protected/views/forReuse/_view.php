<?php
/* @var $this ForReuseController */
/* @var $data ForReuse */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('for_reuse_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->for_reuse_id), array('view', 'id'=>$data->for_reuse_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_number')); ?>:</b>
	<?php echo CHtml::encode($data->order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_number')); ?>:</b>
	<?php echo CHtml::encode($data->article_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile1_number')); ?>:</b>
	<?php echo CHtml::encode($data->textile1_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile2_number')); ?>:</b>
	<?php echo CHtml::encode($data->textile2_number); ?>
	<br />


</div>