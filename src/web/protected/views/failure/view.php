<?php
/* @var $this FailureController */
/* @var $model Failure */

$this->breadcrumbs=array(
	'Failures'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Failure', 'url'=>array('index')),
	array('label'=>'Create Failure', 'url'=>array('create')),
	array('label'=>'Update Failure', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Failure', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Failure', 'url'=>array('admin')),
);
?>

<h1>View Failure #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
