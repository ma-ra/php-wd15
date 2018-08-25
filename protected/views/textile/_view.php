<?php
/* @var $this TextileController */
/* @var $data Textile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->textile_id), array('view', 'id'=>$data->textile_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_number')); ?>:</b>
	<?php echo CHtml::encode($data->textile_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_name')); ?>:</b>
	<?php echo CHtml::encode($data->textile_name); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_description')); ?>:</b>
	<?php echo CHtml::encode($data->textile_description); ?>
	<br />
	

	<b><?php echo CHtml::encode($data->getAttributeLabel('textile_price_group')); ?>:</b>
	<?php echo CHtml::encode($data->textile_price_group); ?>
	<br />


</div>