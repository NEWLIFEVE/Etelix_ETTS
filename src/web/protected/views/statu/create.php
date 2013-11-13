<?php
/* @var $this StatuController */
/* @var $model Statu */

$this->breadcrumbs=array(
	'Status'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Statu', 'url'=>array('index')),
	array('label'=>'Manage Statu', 'url'=>array('admin')),
);
?>

<h1>Create Statu</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>