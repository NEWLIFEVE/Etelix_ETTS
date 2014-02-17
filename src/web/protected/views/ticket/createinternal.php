<?php
$form=$this->beginWidget('CActiveForm',array(
    'id'=>'ticket-form',
    /**
     * Please note: When you enable ajax validation, make sure the corresponding
     * controller action is handling ajax validation correctly.
     * There is a call to performAjaxValidation() commented in generated controller code.
     * See class documentation of CActiveForm for details on this.
     */
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array('enctype'=>'multipart/form-data','onsubmit'=>'return false'),
)); ?>

<div class="span9">
    <h2>Ticket Information</h2>
    <div class="example">
        <?php $this->renderPartial('_forminternal',array('form'=>$form,'model'=>$model)); ?>
    </div>
</div>

<div class="span3">
    <h2>Attach File <i class="icon-file on-right on-left"></i></h2>
    <div class="example" style="padding: 0px; border: none;">
        <?php
        $this->widget('ext.EAjaxUpload.EAjaxUpload',array(
            'id'=>'uploadFile',
            'config'=>array(
                'action'=>Yii::app()->createUrl('file/upload'),
                'allowedExtensions'=>array('pdf', 'gif', 'jpeg', 'png', 'jpg', 'xlsx', 'xls', 'txt'),
                'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                'minSizeLimit'=>512,// minimum file size in bytes
                'onComplete'=>"js:function(id, fileName, responseJSON){ $('#content_attached_file').append('<input type=\'hidden\' name=\'attachFile[]\' value=\''+fileName+'\'> <input type=\'hidden\' name=\'attachFileSave[]\' value=\''+responseJSON.filename+'\'> <input type=\'hidden\' name=\'attachFileSize[]\' value=\''+responseJSON.size+'\'>'); }",
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
        ));               
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/validationEngine.jquery.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.timeentry.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery/jquery.timeentry.min.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.validationEngine-es.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/jquery/jquery.validationEngine.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/modules/etts.ajax.js',CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/create.user.internal.js',CClientScript::POS_END); ?>
<?php // Yii::app()->clientScript->registerScriptFile('http://js.nicedit.com/nicEdit-latest.js',CClientScript::POS_HEAD); ?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/tickets/textarea.enriquecido.js',CClientScript::POS_HEAD); ?>
