<?php
/* @var $this FailureController */
/* @var $model Failure */

$this->breadcrumbs=array(
	'Failures'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Failure', 'url'=>array('index')),
	array('label'=>'Create Failure', 'url'=>array('create')),
	array('label'=>'View Failure', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Failure', 'url'=>array('admin')),
);
?>

<h1>Update Failure <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>