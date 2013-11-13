<?php
/* @var $this PrioridadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Prioridads',
);

$this->menu=array(
	array('label'=>'Create Prioridad', 'url'=>array('create')),
	array('label'=>'Manage Prioridad', 'url'=>array('admin')),
);
?>

<h1>Prioridads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
