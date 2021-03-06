<?php
/* @var $this ShoppingController */
/* @var $data Shopping */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->shopping_id), array('view', 'id'=>$data->shopping_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_number')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_type')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_collection_fabric_id')); ?>:</b>
	<?php echo CHtml::encode($data->fabric_collection_fabric_id); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_date_of_shipment')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_date_of_shipment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_delivery_date')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_delivery_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_scheduled_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_scheduled_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_delivered_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_delivered_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_price')); ?>:</b>
	<?php echo CHtml::encode($data->article_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_name')); ?>:</b>
	<?php echo CHtml::encode($data->document_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_name')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_notes')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_status')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid')); ?>:</b>
	<?php echo CHtml::encode($data->paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_printed')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_printed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_time')); ?>:</b>
	<?php echo CHtml::encode($data->creation_time); ?>
	<br />

	*/ ?>

</div>