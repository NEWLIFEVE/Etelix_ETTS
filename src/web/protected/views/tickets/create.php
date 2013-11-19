<?php
/* @var $this TicketsController */
/* @var $model Tickets */

$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tickets', 'url'=>array('index')),
	array('label'=>'Manage Tickets', 'url'=>array('admin')),
);
?>

<h1>Open Ticket</h1>
<div class="example">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>



<?php
/*
 * Agregando el archivo javascript
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/create.js',CClientScript::POS_END);
?>