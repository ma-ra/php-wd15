<?php
/* @var $this FabricCollectionController */
/* @var $data FabricCollection */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fabric_id), array('view', 'id'=>$data->fabric_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_number')); ?>:</b>
	<?php echo CHtml::encode($data->fabric_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_name')); ?>:</b>
	<?php echo CHtml::encode($data->fabric_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_price_group')); ?>:</b>
	<?php echo CHtml::encode($data->fabric_price_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fabric_price')); ?>:</b>
	<?php echo CHtml::encode($data->fabric_price); ?>
	<br />


</div>