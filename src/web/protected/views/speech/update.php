<?php
/* @var $this SpeechController */
/* @var $model Speech */

$this->breadcrumbs=array(
	'Speeches'=>array('index'),
	$model->speech=>array('view','id'=>$model->speech),
	'Update',
);

$this->menu=array(
	array('label'=>'List Speech', 'url'=>array('index')),
	array('label'=>'Create Speech', 'url'=>array('create')),
	array('label'=>'View Speech', 'url'=>array('view', 'id'=>$model->speech)),
	array('label'=>'Manage Speech', 'url'=>array('admin')),
);
?>

<h1>Update Speech <?php echo $model->speech; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>