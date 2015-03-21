<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_number')); ?>:</b>
	<?php echo CHtml::encode($data->order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_date')); ?>:</b>
	<?php echo CHtml::encode($data->order_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_order_number')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_comments')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_reference')); ?>:</b>
	<?php echo CHtml::encode($data->order_reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_term')); ?>:</b>
	<?php echo CHtml::encode($data->order_term); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('article_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_buyer_id')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_buyer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('broker_broker_id')); ?>:</b>
	<?php echo CHtml::encode($data->broker_broker_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_manufacturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_manufacturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leg_leg_id')); ?>:</b>
	<?php echo CHtml::encode($data->leg_leg_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_article_id')); ?>:</b>
	<?php echo CHtml::encode($data->article_article_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('printed_minilabel')); ?>:</b>
	<?php echo CHtml::encode($data->printed_minilabel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('printed_shipping_label')); ?>:</b>
	<?php echo CHtml::encode($data->printed_shipping_label); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_prepared')); ?>:</b>
	<?php echo CHtml::encode($data->textile_prepared); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_manufactured')); ?>:</b>
	<?php echo CHtml::encode($data->article_manufactured); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_exported')); ?>:</b>
	<?php echo CHtml::encode($data->article_exported); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_canceled')); ?>:</b>
	<?php echo CHtml::encode($data->article_canceled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_error')); ?>:</b>
	<?php echo CHtml::encode($data->order_error); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_add_date')); ?>:</b>
	<?php echo CHtml::encode($data->order_add_date); ?>
	<br />

	*/ ?>

</div>