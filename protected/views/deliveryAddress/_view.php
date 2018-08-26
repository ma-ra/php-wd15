<?php
/* @var $this DeliveryAddressController */
/* @var $data DeliveryAddress */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->delivery_address_id), array('view', 'id'=>$data->delivery_address_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_name_1')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_name_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_name_2')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_name_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_street')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_zip_code')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_zip_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_city')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_address_contact')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_address_contact); ?>
	<br />


</div>