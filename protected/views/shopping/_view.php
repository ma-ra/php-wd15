<?php
/* @var $this ShoppingController */
/* @var $data Shopping */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->shopping_id), array('view', 'id'=>$data->shopping_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_type')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_textile_id')); ?>:</b>
	<?php echo CHtml::encode($data->textile_textile_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_calculated_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_calculated_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_term')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_term); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_status')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_printed')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_printed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_time')); ?>:</b>
	<?php echo CHtml::encode($data->creation_time); ?>
	<br />

	*/ ?>

</div>