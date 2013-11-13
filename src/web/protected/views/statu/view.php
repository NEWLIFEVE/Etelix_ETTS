<?php
/* @var $this StatuController */
/* @var $model Statu */

$this->breadcrumbs=array(
	'Status'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Statu', 'url'=>array('index')),
	array('label'=>'Create Statu', 'url'=>array('create')),
	array('label'=>'Update Statu', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Statu', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Statu', 'url'=>array('admin')),
);
?>

<h1>View Statu #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'statu',
	),
)); ?>
