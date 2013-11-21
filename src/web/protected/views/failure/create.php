<?php
/* @var $this FailureController */
/* @var $model Failure */

$this->breadcrumbs=array(
	'Failures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Failure', 'url'=>array('index')),
	array('label'=>'Manage Failure', 'url'=>array('admin')),
);
?>

<h1>Create Failure</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>