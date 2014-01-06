<?php
/* @var $this SpeechController */
/* @var $model Speech */

$this->breadcrumbs=array(
	'Speeches'=>array('index'),
	$model->speech,
);

$this->menu=array(
	array('label'=>'List Speech', 'url'=>array('index')),
	array('label'=>'Create Speech', 'url'=>array('create')),
	array('label'=>'Update Speech', 'url'=>array('update', 'id'=>$model->speech)),
	array('label'=>'Delete Speech', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->speech),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Speech', 'url'=>array('admin')),
);
?>

<h1>View Speech #<?php echo $model->speech; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'speech',
	),
)); ?>
