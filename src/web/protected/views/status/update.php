<?php
/* @var $this StatuController */
/* @var $model Statu */

$this->breadcrumbs=array(
	'Status'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Statu', 'url'=>array('index')),
	array('label'=>'Create Statu', 'url'=>array('create')),
	array('label'=>'View Statu', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Statu', 'url'=>array('admin')),
);
?>

<h1>Update Statu <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>