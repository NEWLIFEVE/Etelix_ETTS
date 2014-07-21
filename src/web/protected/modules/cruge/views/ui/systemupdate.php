<?php
	/* formulario de edicion de CrugeSystem

		argumento:

		$model: instancia de ICrugeSession
	*/
?>

<?php
	if(Yii::app()->user->hasFlash('systemFormFlash'))  {
		echo "<div class='flash-success'>";
		echo Yii::app()->user->getFlash('systemFormFlash');
		echo "</div>";
	}
?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'CrugeSystem-Form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
)); ?>
<div class="example">
    <fieldset>
        <legend>Session Options</legend>
        <div class="row2">
            <div class="input-control checkbox span2" data-role="input-control">
                <label>
                    <?php //echo $form->labelEx($model,'systemdown'); ?>
                    <?php echo $form->checkBox($model,'systemdown'); ?>
                    <span class="check"></span> Stop System
                    <?php echo $form->error($model,'systemdown'); ?>
                </label>
            </div>
            <div class="input-control checkbox span3" data-role="input-control">
                <label>
                    <?php //echo $form->labelEx($model,'systemnonewsessions'); ?>
                    <?php echo $form->checkBox($model,'systemnonewsessions'); ?>
                    <span class="check"></span> Not admit new sessions
                    <?php echo $form->error($model,'systemnonewsessions'); ?>
                </label>
            </div>
            <div class='input-control text span4'>
                    <?php echo $form->labelEx($model,'sessionmaxdurationmins'); ?>
                    <?php echo $form->textField($model,'sessionmaxdurationmins'
                            ,array('size'=>5,'maxlength'=>4)); ?>
                    <?php echo $form->error($model,'sessionmaxdurationmins'); ?>
            </div>
        </div>
    </fieldset>
</div>
<div class="example">
    <fieldset>
        <legend>User Registration Option</legend>
        <div class="row2">
            <div class='input-control checkbox span3'>
                <label>
                    <?php //echo $form->labelEx($model,'registerusingcaptcha'); ?>
                    <?php echo $form->checkBox($model,'registerusingcaptcha'); ?>
                    <span class="check"></span> Register with Captcha
                    <?php echo $form->error($model,'registerusingcaptcha'); ?>
                </label>
            </div>

            <div class='input-control checkbox span3'>
                <label>
                    <?php // echo $form->labelEx($model,'registrationonlogin'); ?>
                    <?php echo $form->checkBox($model,'registrationonlogin'); ?>
                    <span class="check"></span> Registration On Login
                    <?php echo $form->error($model,'registrationonloginn'); ?>
                </label>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control select span5'>
                    <?php echo $form->labelEx($model,'registerusingactivation'); ?>
                    <?php echo $form->dropDownList($model,'registerusingactivation'
                            ,Yii::app()->user->um->getUserActivationOptions()); ?>
                    <?php echo $form->error($model,'registerusingactivation'); ?>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control select span5'>
                    <?php echo $form->labelEx($model,'defaultroleforregistration'); ?>
                    <?php echo $form->dropDownList($model,'defaultroleforregistration'
                            ,Yii::app()->user->rbac->getRolesAsOptions(CrugeTranslator::t(
                                    "--no asignar ningun rol--"))); ?>
                    <?php echo $form->error($model,'defaultroleforregistration'); ?>
            </div>
        </div>
    </fieldset>
</div>

<div class="example">
    <fieldset>
        <legend>Term Of Service</legend>
	<div class='row2'>
		<div class='input-control checkbox'>
                    <labe>
			<?php echo $form->checkBox($model,'registerusingterms'); ?>
                        <span class="check"></span> <?php echo strip_tags($form->labelEx($model,'registerusingterms')); ?>
			<?php echo $form->error($model,'registerusingterms'); ?>
                    </labe>
		</div>
        </div>
        
        <div class="row2">
		<div class='input-control text span5'>
			<?php echo $form->labelEx($model,'registerusingtermslabel'); ?>
			<?php echo $form->textField($model,'registerusingtermslabel'
				,array('size'=>45,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'registerusingtermslabel'); ?>
		</div>
	</div>
	
        <div class="row2">
            <div class='input-control textarea span5'>
                    <?php echo $form->labelEx($model,'terms'); ?>
                    <?php echo $form->textArea($model,'terms'
                            ,array('rows'=>10,'cols'=>50)); ?>
                    <?php echo $form->error($model,'terms'); ?>
            </div>
        </div>
    </fieldset>
</div>


<div class="row buttons center">
	<?php echo CHtml::submitButton('Update', array('class' => 'primary large', 'name'=>'Submit')); ?>
</div>
<?php echo $form->errorSummary($model); ?>
<?php $this->endWidget(); ?>