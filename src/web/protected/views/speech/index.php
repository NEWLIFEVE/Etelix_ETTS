<?php
/* @var $this SpeechController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Speeches',
);

$this->menu=array(
	array('label'=>'Create Speech', 'url'=>array('create')),
	array('label'=>'Manage Speech', 'url'=>array('admin')),
);
?>

<h1>Speeches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
