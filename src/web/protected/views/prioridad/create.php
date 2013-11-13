<?php
/* @var $this PrioridadController */
/* @var $model Prioridad */

$this->breadcrumbs=array(
	'Prioridads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Prioridad', 'url'=>array('index')),
	array('label'=>'Manage Prioridad', 'url'=>array('admin')),
);
?>

<h1>Create Prioridad</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>