<?php
/* @var $this PrioridadController */
/* @var $model Prioridad */

$this->breadcrumbs=array(
	'Prioridads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Prioridad', 'url'=>array('index')),
	array('label'=>'Create Prioridad', 'url'=>array('create')),
	array('label'=>'View Prioridad', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Prioridad', 'url'=>array('admin')),
);
?>

<h1>Update Prioridad <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>