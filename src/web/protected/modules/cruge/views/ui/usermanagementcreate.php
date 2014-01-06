<div class="span12">
    <h2>Create New User</h2>
    <div class="example">
        
        <?php
                /*
                        $model:  es una instancia que implementa a ICrugeStoredUser
                */
        ?>
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'crugestoreduser-form',
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>false,
        )); ?>
        
        <?php echo $form->errorSummary($model); ?>
        
        <div class="grid">
            <div class="row">
                <div class="span2">
                    <div class="input-control text span2">
                            <?php echo $form->labelEx($model,'username'); ?>
                            <?php echo $form->textField($model,'username'); ?>
                            <?php echo $form->error($model,'username'); ?>
                    </div>
                </div>
                
                <div class="span2">
                    <div class="input-control text span2">
                            <?php echo $form->labelEx($model,'email'); ?>
                            <?php echo $form->textField($model,'email'); ?>
                            <?php echo $form->error($model,'email'); ?>
                    </div>
                </div>
                
                <div class="span2">
                    <div class="input-control text span2">
                        <?php echo $form->labelEx($model,'newPassword'); ?>
                        <?php echo $form->textField($model,'newPassword'); ?>
                        <?php echo $form->error($model,'newPassword'); ?>
                    </div>
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
                                ,array('success'=>'js:fnSuccess','error'=>'js:fnError')
                                ,array('class' => 'default')
                        ); 
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
        
        <div class="grid">
            <div class="row">
                <?php 
                foreach($model->getFields() as $f){
                        // aqui $f es una instancia que implementa a: ICrugeField
                        echo "<div class='span2'>";
                            echo "<div class='input-control text span2'>";
                                echo Yii::app()->user->um->getLabelField($f);
                                echo Yii::app()->user->um->getInputField(null, $f);
                                echo $form->error($model,$f->fieldname);
                            echo "</div>";
                        echo "</div>";
                }
                ?>
            </div>
        </div>
        
        
        <div class="separador-vertical"></div>
        
        <div class="grid">
            <div class="row">
                
                <div class="span3">
                    <div class="input-control text span3">
                        <?php  echo CHtml::submitButton('Save', array('class' => 'primary')); ?>
                    </div>
                </div>
                
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>