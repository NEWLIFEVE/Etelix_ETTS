<?php
/* @var $this TicketsController */
/* @var $model Tickets */

$this->breadcrumbs=array(
	'Tickets'=>array('index'),
	'Create',
);

$this->menu=array(
        array('label'=>'My tickets', 'url'=>array('/ticket/admin')),
        array('label'=>'Open ticket', 'url'=>array('/ticket/create')),
);
?>
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ticket-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<div class="span9">
    <h2>Ticket Information</h2>
    <div class="example">
        <?php $this->renderPartial('_form', array('form'=>$form,'model'=>$model)); ?>
    </div>
</div>

<div class="span3">
    
    <h2>Attach File <i class="icon-file on-right on-left"></i></h2>
    <div class="example" style="padding: 0px; border: none;">
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
            array(
                    'id'=>'uploadFile',
                    'config'=>array(
                           'action'=>Yii::app()->createUrl('file/upload'),
                           'allowedExtensions'=>array('pdf', 'gif', 'jpeg', 'png', 'jpg', 'xlsx', 'xls', 'txt'),
                           'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                           'minSizeLimit'=>512,// minimum file size in bytes
                           /*'onComplete'=>"js:function(id, fileName, responseJSON){ alert(fileName); }",
                           'messages'=>array(
                                             'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                                             'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                                             'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                                             'emptyError'=>"{file} is empty, please select files again without it.",
                                             'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                            ),
                           'showMessage'=>"js:function(message){ alert(message); }"*/
                          )
        )); ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/create.js',CClientScript::POS_END); ?>


<?php //******************OLD-ONE**************************/
/* @var $this TicketController */
/* @var $model Ticket */
//
//$this->breadcrumbs=array(
//	'Tickets'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Ticket', 'url'=>array('index')),
//	array('label'=>'Manage Ticket', 'url'=>array('admin')),
//);
//?>

<!--<h1>Create Ticket</h1>-->

<?php // echo $this->renderPartial('_form', array('model'=>$model)); ?>