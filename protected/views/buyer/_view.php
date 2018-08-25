<?php
/* @var $this BuyerController */
/* @var $data Buyer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->buyer_id), array('view', 'id'=>$data->buyer_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_name_1')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_name_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_name_2')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_name_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_street')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_zip_code')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_zip_code); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_city')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('buyer_contact')); ?>:</b>
	<?php echo CHtml::encode($data->buyer_contact); ?>
	<br />


</div>