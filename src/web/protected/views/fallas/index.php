<?php
/* @var $this FallasController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fallases',
);

$this->menu=array(
	array('label'=>'Create Fallas', 'url'=>array('create')),
	array('label'=>'Manage Fallas', 'url'=>array('admin')),
);
?>

<h1>Fallases</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
