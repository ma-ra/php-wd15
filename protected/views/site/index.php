<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . " - Wyrwał Daniel 2015";
?>

<ul>
	<li><?php echo CHtml::link('Artykuły',array('Article/admin')); ?></li>
	<li><?php echo CHtml::link('Pośrednik',array('Broker/admin')); ?></li>
	<li><?php echo CHtml::link('Kupujący',array('Buyer/admin')); ?></li>
	<li><?php echo CHtml::link('Nogi',array('Leg/admin')); ?></li>
	<li><?php echo CHtml::link('Producent',array('Manufacturer/admin')); ?></li>
	<li><?php echo CHtml::link('Zamówienia',array('Order/admin')); ?></li>
	<li><?php echo CHtml::link('Materiały',array('Textile/admin')); ?></li>
	<li><?php echo CHtml::link('Spis materiałów',array('FabricCollection/admin')); ?></li>
	<li><?php echo CHtml::link('Wykroje do ponownego użycia',array('ForReuse/admin')); ?></li>
	<li><?php echo CHtml::link('Dostawcy',array('Supplier/admin')); ?></li>
	<li><?php echo CHtml::link('Zakupy',array('Shopping/admin')); ?></li>
	<li><?php echo CHtml::link('Logi',array('Log/admin')); ?></li>
	<li><?php echo CHtml::link('Konfiguracja',array('Configuration/admin')); ?></li>
</ul>