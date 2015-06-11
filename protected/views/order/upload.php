<?php
/* @var $this OrderController */
/* @var $model Order */

$this->breadcrumbs=array(
	'Lista zamówień'=>array('admin'),
	'Wczytaj',
);

$this->menu=array(
	array('label'=>'Lista zamówień', 'url'=>array('admin')),
);
?>

<h1>Wczytywanie zamówień</h1>
<p>
W przypadku przeglądarki Firefox, można przeciągnać plik na przycisk wczytaj.<br>
Po każdym wczytaniu zaleca się skonfigurować nowe artykóły, oraz na liście zamówień poszukać wykrytych błędów.
</p>

<?php $this->renderPartial('upload_form', array('model'=>$model)); ?>