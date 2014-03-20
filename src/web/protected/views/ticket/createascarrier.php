<?php
/**
 * Vista en donde se crean los tickets Carrier a Etelix desde Etelix
 * @var $this TicketsController
 * @var $model Tickets 
 */
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
	'id'=>'ticket-form-to-client',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onsubmit' => 'return false'),
)); ?>




<div class="span9">
    <h2>Ticket Information - Open TT from Carrier by Etelix</h2>
    <div class="example">
        <?php $this->renderPartial('_formascarrier', array('form'=>$form,'model'=>$model)); ?>
    </div>
</div>

<div class="span3">
    
    <h2>Attach File <i class="icon-file on-right on-left"></i></h2>
    <div class="example" style="padding: 0px; border: none;">
        <?php 
        $this->widget('ext.EAjaxUpload.EAjaxUpload',
            array(
                    'id'=>'uploadFile',
                    'config'=>array(
                           'action'=>Yii::app()->createUrl('file/upload'),
                           'allowedExtensions'=>array('pdf', 'gif', 'jpeg', 'png', 'jpg', 'xlsx', 'xls', 'txt', 'cap', 'pcap', 'csv'),
                           'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                           'minSizeLimit'=>1,// minimum file size in bytes
                           'onComplete'=>"js:function(id, fileName, responseJSON){ $('#content_attached_file').append('<input type=\'hidden\' name=\'attachFile[]\' value=\''+fileName+'\'> <input type=\'hidden\' name=\'attachFileSave[]\' value=\''+responseJSON.filename+'\'> <input type=\'hidden\' name=\'attachFileSize[]\' value=\''+responseJSON.size+'\'>'); }",
                          )
        )); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/validationEngine.jquery.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.timeentry.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/datepicker.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery/jquery.timeentry.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.validationEngine-es.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.validationEngine.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.ajax.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/create.user.internal.js',CClientScript::POS_END); ?>
