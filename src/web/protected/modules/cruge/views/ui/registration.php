<div class="span12">
    <h2>Create New User</h2>
    <!--<div class="form">-->
    <?php
            /*
                    $model:  es una instancia que implementa a ICrugeStoredUser
            */
    ?>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'registration-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
    )); ?>
    <div class="example">
        
            <legend>Account data</legend>
            
<!--            <div class="separador-vertical"></div>
            <?php // echo $form->labelEx($model, 'id_carrier') ?>
            <?php // echo $form->dropDownList($model,'id_carrier', Carrier::getCarriers(),  array('empty' => 'Select carrier')); ?>
            <span id="disable_enable">Disable</span> <input type="checkbox" id="disable_carrier" name="disable_carrier" value="ok">
            <?php // echo $form->error($model, 'id_carrier'); ?>
            <div class="separador-vertical"></div>-->
            
            
            <div class="input-control select block">
                <?php echo $form->labelEx($model, 'id_carrier') ?>
                <?php echo $form->dropDownList($model,'id_carrier', Carrier::getCarriers(),  array('empty' => 'Select carrier', 'style' => 'width:390px')); ?>
                <span id="disable_enable">Disable</span> <input type="checkbox" id="disable_carrier" name="disable_carrier" value="ok">
                <?php echo $form->error($model, 'id_carrier'); ?>
                
            </div>
            
            <?php 
                    foreach (CrugeUtil::config()->availableAuthModes as $authmode){
                        echo "<div class='input-control text block span6'>";
                            echo $form->labelEx($model,$authmode);
                            echo $form->textField($model,$authmode);
                            echo $form->error($model,$authmode);
                        echo "</div>";
                    }
            ?>

<!--        <div id="content_password" class="row">   -->
                <div class="input-control text span4">
                    <?php echo $form->labelEx($model,'newPassword'); ?>
                    <?php echo $form->textField($model,'newPassword'); ?>
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
                        <?php 
                        echo CHtml::ajaxbutton(
                        CrugeTranslator::t("Generate a new key")
                        ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                        ,array('success'=>new CJavaScriptExpression('fnSuccess'),
                                'error'=>new CJavaScriptExpression('fnError'))
                        ,array('class' => 'default')
                        );  
                        ?>
                    </div>
                </div>
            <!--</div>-->
            <!--<div></div>-->
            <?php // echo CHtml::submitButton('Save', array('class' => 'primary large', 'name'=>'preview', 'style' => 'width:460px')); ?>
           
    </div>


    <!-- inicio de campos extra definidos por el administrador del sistema -->
    <?php 
            if(count($model->getFields()) > 0){
                    echo "<div class='example'>";
                    echo '<legend>Profile</legend>';
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


    <!-- inicio - terminos y condiciones -->
    <?php
            if(Yii::app()->user->um->getDefaultSystem()->getn('registerusingterms') == 1)
            {
    ?>
    <div class='example'>
            <h6><?php echo ucfirst(CrugeTranslator::t("terminos y condiciones"));?></h6>
            <?php echo CHtml::textArea('terms'
                    ,Yii::app()->user->um->getDefaultSystem()->get('terms')
                    ,array('readonly'=>'readonly','rows'=>5,'cols'=>'80%')
                    ); ?>
            <div><span class='required'>*</span><?php echo CrugeTranslator::t(Yii::app()->user->um->getDefaultSystem()->get('registerusingtermslabel')); ?></div>
            <?php echo $form->checkBox($model,'terminosYCondiciones'); ?>
            <?php echo $form->error($model,'terminosYCondiciones'); ?>
    </div>
    <!-- fin - terminos y condiciones -->
    <?php } ?>



    <!-- inicio pide captcha -->
    <?php if(Yii::app()->user->um->getDefaultSystem()->getn('registerusingcaptcha') == 1) { ?>
    <div class='example'>
            <legend>Security code</legend>
            <div class="row">
                    <div>
                            <?php $this->widget('CCaptcha'); ?>
                            <?php echo $form->textField($model,'verifyCode'); ?>
                    </div>
                    <div class="hint"><?php echo CrugeTranslator::t("por favor ingrese los caracteres o digitos que vea en la imagen");?></div>
                    <?php echo $form->error($model,'verifyCode'); ?>
            </div>
    </div>
    <?php } ?>
    <!-- fin pide captcha-->
    <div class="row buttons" style="text-align: center;">
	<?php echo CHtml::submitButton('Save', array('class' => 'primary large', 'name'=>'preview', 'style' => 'width:500px')); ?>
    </div>
    <?php // echo $form->errorSummary($model); ?>
    <?php $this->endWidget(); ?>
    <!--</div>-->
</div>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/cruge/registration.js',CClientScript::POS_END); ?>