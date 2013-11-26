<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('loginflash'); ?>
</div>
<?php else: ?>
<h1 id="_default" class=""><i class="on-left"></i></h1>
<div id="logueo" class="example">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logon-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<fieldset>
                <legend><h1>Log In  <i class="icon-user-3 on-left"></i></h1></legend>
        <div class="input-control text" data-role="input-control">
		<?php echo $form->textField($model,'username', array('placeholder' => 'User')); ?>
                <button class="btn-clear" tabindex="-1"></button>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="input-control password" data-role="input-control">
		<?php echo $form->passwordField($model,'password', array('placeholder' => 'Password')); ?>
                <button class="btn-reveal" tabindex="-1"></button>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="input-control checkbox" data-role="input-control">
                <label>
                    <?php echo $form->checkBox($model,'rememberMe'); ?>
                    <span class="check"></span>  Remember Me &nbsp;&nbsp; <?php echo Yii::app()->user->ui->passwordRecoveryLink; ?>
                    <?php echo $form->error($model,'rememberMe'); ?>
                </label>
	</div>
                
        <div></div>
        
            <?php echo CHtml::submitButton('Go!', array('class' => 'primary large')); ?>
            <?php // Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login")); ?>
            
            <?php
//			if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
//				echo Yii::app()->user->ui->iregistrationLink;
            ?>

	<?php
		//	si el componente CrugeConnector existe lo usa:
		//
		if(Yii::app()->getComponent('crugeconnector') != null){
		if(Yii::app()->crugeconnector->hasEnabledClients){ 
	?>
	<div class='crugeconnector'>
		<span><?php echo CrugeTranslator::t('logon', 'You also can login with');?>:</span>
		<ul>
		<?php 
			$cc = Yii::app()->crugeconnector;
			foreach($cc->enabledClients as $key=>$config){
				$image = CHtml::image($cc->getClientDefaultImage($key));
				echo "<li>".CHtml::link($image,
					$cc->getClientLoginUrl($key))."</li>";
			}
		?>
		</ul>
	</div>
	<?php }} ?>
	
        </fieldset>
<?php $this->endWidget(); ?>
</div>
<?php endif; ?>