<?php if (Yii::app()->user->isGuest): ?>
    <?php
    /* @var $this SiteController */
    /* @var $model LoginForm */
    /* @var $form CActiveForm  */

    $this->pageTitle=Yii::app()->name . ' - Login';
    $this->breadcrumbs=array(
            'Login',
    );
    ?>
    <h1 id="_default" class=""><i class="icon-accessibility on-left"></i>Accede a tu cuenta</h1>
    <div id="logueo" class="example">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                    'validateOnSubmit'=>true,
            ),
    )); ?>
            <fieldset>
                <legend><h1>Iniciar sesión <i class="icon-user-3 on-left"></i></h1></legend>
            <div class="input-control text" data-role="input-control">
                    <?php echo $form->textField($model,'username', array('placeholder' => 'user')); ?>
                    <button class="btn-clear" tabindex="-1"></button>
                    <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="input-control password" data-role="input-control">
                    <?php echo $form->passwordField($model,'password', array('placeholder' => 'password')); ?>
                    <button class="btn-reveal" tabindex="-1"></button>
                    <?php echo $form->error($model,'password'); ?>
            </div>

            <div class="input-control checkbox" data-role="input-control">
                    <label>
                    <?php echo $form->checkBox($model,'rememberMe'); ?>
                    <span class="check"></span>  Recordar cuenta
                    <?php echo $form->error($model,'rememberMe'); ?>
                    </label>
            </div>

            <div></div>

            <?php echo CHtml::submitButton('Login', array('class' => 'primary large')); ?>

        </fieldset>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php else: ?>
    <?php $this->pageTitle=Yii::app()->name . ' - Bienvenido'; ?>
    <h1>Bienvenido</h1>
<?php endif; ?>