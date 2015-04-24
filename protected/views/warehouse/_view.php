<?php
/* @var $this WarehouseController */
/* @var $data Warehouse */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->warehouse_id), array('view', 'id'=>$data->warehouse_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_type')); ?>:</b>
	<?php echo CHtml::encode($data->warehouse_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_number')); ?>:</b>
	<?php echo CHtml::encode($data->article_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_name')); ?>:</b>
	<?php echo CHtml::encode($data->article_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_count')); ?>:</b>
	<?php echo CHtml::encode($data->article_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_price')); ?>:</b>
	<?php echo CHtml::encode($data->article_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('document_name')); ?>:</b>
	<?php echo CHtml::encode($data->document_name); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_error')); ?>:</b>
	<?php echo CHtml::encode($data->warehouse_error); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shopping_shopping_id')); ?>:</b>
	<?php echo CHtml::encode($data->shopping_shopping_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($data->creation_date); ?>
	<br />

	*/ ?>

</div>