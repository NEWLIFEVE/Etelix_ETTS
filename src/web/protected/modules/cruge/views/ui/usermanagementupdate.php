<?php
	/*
		$model:  
			es una instancia que implementa a ICrugeStoredUser, y debe traer ya los campos extra 	accesibles desde $model->getFields()
		
		$boolIsUserManagement: 
			true o false.  si es true indica que esta operandose bajo el action de adminstracion de usuarios, si es false indica que se esta operando bajo 'editar tu perfil'
	*/
?>
<div class="span12">
    <h2><?php echo ucwords(CrugeTranslator::t(	
            $boolIsUserManagement ? "update user" : "update profile"
    ));?></h2>
    <div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'crugestoreduser-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
    )); ?>
    <div class="example">

            <!--<div class='field-group'>-->
                    <legend>Account data</legend>
                    <div class='input-control text block span6'>
                            <?php echo $form->labelEx($model,'username'); ?>
                            <?php echo $form->textField($model,'username'); ?>
                            <?php echo $form->error($model,'username'); ?>
                    </div>
                    <div class='input-control text block span6'>
                            <?php echo $form->labelEx($model,'email'); ?>
                            <?php echo $form->textField($model,'email'); ?>
                            <?php echo $form->error($model,'email'); ?>
                    </div>
                    <div class='input-control text span4'>
                            <?php echo $form->labelEx($model,'newPassword'); ?>
                            <?php echo $form->textField($model,'newPassword',array('size'=>10)); ?>
                            <?php echo $form->error($model,'newPassword'); ?>
                    </div>
                    <div class="span2">
                        <div class="input-control text span2">
                            <script>
                                    function fnSuccess(data){
                                            $('#CrugeStoredUser_newPassword').val(data);
                                    }
                                    function fnError(e){
                                            alert("error: "+e.responseText);
                                    }
                            </script>
                            <p></p><br>
                            <?php echo CHtml::ajaxbutton(
                                    CrugeTranslator::t("Generate a new key")
                                    ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                                    ,array('success'=>new CJavaScriptExpression('fnSuccess'),
                                            'error'=>new CJavaScriptExpression('fnError'))
                                    ,array('class' => 'default')
                            ); ?>
                        </div>
                    </div>
                    
            <!--</div>-->
            <div style="clear: left"></div>
            <!--<div class='field-group'>-->

                    <div class='col textfield-readonly'>
                            <?php echo $form->labelEx($model,'regdate'); ?>
                            <?php echo $form->textField($model,'regdate'
                                            ,array(
                                                    'readonly'=>'readonly',
                                                    'value'=>Yii::app()->user->ui->formatDate($model->regdate),
                                            )
                            ); ?>
                    </div>
                    <div class='col textfield-readonly'>
                            <?php echo $form->labelEx($model,'actdate'); ?>
                            <?php echo $form->textField($model,'actdate'
                                            ,array(
                                                    'readonly'=>'readonly',
                                                    'value'=>Yii::app()->user->ui->formatDate($model->actdate),
                                            )
                                    ); ?>
                    </div>
                    <div class='col textfield-readonly'>
                            <?php echo $form->labelEx($model,'logondate'); ?>
                            <?php echo $form->textField($model,'logondate'
                                            ,array(
                                                    'readonly'=>'readonly',
                                                    'value'=>Yii::app()->user->ui->formatDate($model->logondate),
                                            )
                                    ); ?>
                    </div>

            <!--</div>-->
    </div>
    <!-- inicio de campos extra definidos por el administrador del sistema -->
    <?php 
            if(count($model->getFields()) > 0){
                    echo "<div class='example'>";
                    echo "<legend>Profile</legend>";
                    foreach($model->getFields() as $f){
                            // aqui $f es una instancia que implementa a: ICrugeField
                            echo "<div class='input-control text block span6'>";
                            echo Yii::app()->user->um->getLabelField($f);
                            echo Yii::app()->user->um->getInputField($model,$f);
                            echo $form->error($model,$f->fieldname);
                            echo "</div>";
                    }
                    echo "</div>";
            }
    ?>
    <!-- fin de campos extra definidos por el administrador del sistema -->




    <!-- inicio de opciones avanazadas, solo accesible bajo el rol 'admin' -->

    <?php 
            if($boolIsUserManagement)
            if(Yii::app()->user->checkAccess('edit-advanced-profile-features'
                    ,__FILE__." linea ".__LINE__))
                    $this->renderPartial('_edit-advanced-profile-features'
                            ,array('model'=>$model,'form'=>$form),false); 
    ?>

    <!-- fin de opciones avanazadas, solo accesible bajo el rol 'admin' -->





    <div class="row buttons">
            <?php Yii::app()->user->ui->tbutton("Guardar Cambios"); ?>

    </div>
    <?php echo $form->errorSummary($model); ?>
    <?php $this->endWidget(); ?>
    </div>
</div>