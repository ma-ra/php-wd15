<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->article_id), array('view', 'id'=>$data->article_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_number')); ?>:</b>
	<?php echo CHtml::encode($data->article_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_name')); ?>:</b>
	<?php echo CHtml::encode($data->model_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('model_type')); ?>:</b>
	<?php echo CHtml::encode($data->model_type); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('model_description')); ?>:</b>
	<?php echo CHtml::encode($data->model_description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_colli')); ?>:</b>
	<?php echo CHtml::encode($data->article_colli); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_all_textile_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_all_textile_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_first_textile_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_first_textile_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article_second_textile_amount')); ?>:</b>
	<?php echo CHtml::encode($data->article_second_textile_amount); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg1')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg2')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg3')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg4')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg5')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg6')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg6); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_in_pg7')); ?>:</b>
	<?php echo CHtml::encode($data->price_in_pg7); ?>
	<br />

</div>