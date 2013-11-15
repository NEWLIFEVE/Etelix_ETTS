<?php
/* @var $this StatuController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Status',
);

$this->menu=array(
	array('label'=>'Create Statu', 'url'=>array('create')),
	array('label'=>'Manage Statu', 'url'=>array('admin')),
);
?>

<h1>Status</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
