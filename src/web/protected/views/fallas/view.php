<?php
/* @var $this FallasController */
/* @var $model Fallas */

$this->breadcrumbs=array(
	'Fallases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Fallas', 'url'=>array('index')),
	array('label'=>'Create Fallas', 'url'=>array('create')),
	array('label'=>'Update Fallas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Fallas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Fallas', 'url'=>array('admin')),
);
?>

<h1>View Fallas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clase_id',
		'falla',
	),
)); ?>
