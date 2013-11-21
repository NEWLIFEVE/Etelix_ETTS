<?php
/* @var $this SpeechController */
/* @var $model Speech */

$this->breadcrumbs=array(
	'Speeches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Speech', 'url'=>array('index')),
	array('label'=>'Manage Speech', 'url'=>array('admin')),
);
?>

<h1>Create Speech</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>