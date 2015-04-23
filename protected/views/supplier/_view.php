<?php
/* @var $this SupplierController */
/* @var $data Supplier */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->supplier_id), array('view', 'id'=>$data->supplier_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_name')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_tel')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_email')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_textile_id')); ?>:</b>
	<?php echo CHtml::encode($data->textile_textile_id); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_lang')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_lang); ?>
	<br />


</div>