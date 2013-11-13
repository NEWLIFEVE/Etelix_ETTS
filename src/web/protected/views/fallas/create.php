<?php
/* @var $this FallasController */
/* @var $model Fallas */

$this->breadcrumbs=array(
	'Fallases'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Fallas', 'url'=>array('index')),
	array('label'=>'Manage Fallas', 'url'=>array('admin')),
);
?>

<h1>Create Fallas</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>