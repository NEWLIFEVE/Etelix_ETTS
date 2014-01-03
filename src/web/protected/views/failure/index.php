<?php
/* @var $this FailureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Failures',
);

$this->menu=array(
	array('label'=>'Create Failure', 'url'=>array('create')),
	array('label'=>'Manage Failure', 'url'=>array('admin')),
);
?>

<h1>Failures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
