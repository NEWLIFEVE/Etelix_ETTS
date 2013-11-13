<?php
/* @var $this FallasController */
/* @var $model Fallas */

$this->breadcrumbs=array(
	'Fallases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Fallas', 'url'=>array('index')),
	array('label'=>'Create Fallas', 'url'=>array('create')),
	array('label'=>'View Fallas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Fallas', 'url'=>array('admin')),
);
?>

<h1>Update Fallas <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>