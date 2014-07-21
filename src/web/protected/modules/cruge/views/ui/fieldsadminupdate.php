<?php
	/*
		$model:  es una instancia que implementa a ICrugeField
	*/
?>
<h2><?php echo ucwords(CrugeTranslator::t(	
		(($model->isNewRecord==1) ? "creating new custom field" :"updating custom field")
	));?></h2>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'crugefield-form',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>false,
)); ?>
<div class="example">
    <fieldset>
        <legend>Field Data</legend>
        <div class="row2">
            <div class='input-control text span5'>
                    <?php echo $form->labelEx($model,'fieldname'); ?>
                    <?php echo $form->textField($model,'fieldname',array('size'=>15,'maxlength'=>20)); ?>
                    <?php echo $form->error($model,'fieldname'); ?>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control text span5'>
                    <?php echo $form->labelEx($model,'longname'); ?>
                    <?php echo $form->textField($model,'longname'); ?>
                    <?php echo $form->error($model,'longname'); ?>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control text span2'>
                    <?php echo $form->labelEx($model,'position'); ?>
                    <?php echo $form->textField($model,'position',array('size'=>5,'maxlength'=>3)); ?>
                    <?php echo $form->error($model,'position'); ?>
            </div>
        </div>
        <div class="row2">
            <div class="input-control checkbox" data-role="input-control"'>
                <label>
                    <?php // echo $form->labelEx($model,'required'); ?>
                    <?php echo $form->checkBox($model,'required'); ?>
                    <span class="check"></span>  Required
                    <?php echo $form->error($model,'required'); ?>
                </label>
            </div>
            <div class="input-control checkbox" data-role="input-control">
                <label>
                   <?php //echo $form->labelEx($model,'showinreports'); ?>
                   <?php echo $form->checkBox($model,'showinreports'); ?>
                    <span class="check"></span> Show in Reports
                   <?php echo $form->error($model,'showinreports'); ?>
                </label>
            </div>
        </div>
    </fieldset>
</div>

<div class="example">
    <fieldset>
        <legend>Content Data</legend>
        <div class="row2">
            <div class='input-control select span5'>
                    <?php echo $form->labelEx($model,'fieldtype'); ?>
                    <?php echo $form->dropDownList($model,'fieldtype'
                            ,Yii::app()->user->um->getFieldTypeOptions()); ?>
                    <?php echo $form->error($model,'fieldtype'); ?>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control text span5'>
                    <?php echo $form->labelEx($model,'fieldsize'); ?>
                    <?php echo $form->textField($model,'fieldsize',array('size'=>5,'maxlength'=>3)); ?>
                    <?php echo $form->error($model,'fieldsize'); ?>
            </div>
        </div>
        
        <div class="row2">
            <div class='input-control text span5'>
                    <?php echo $form->labelEx($model,'maxlength'); ?>
                    <?php echo $form->textField($model,'maxlength',array('size'=>8,'maxlength'=>20)); ?>
                    <?php echo $form->error($model,'maxlength'); ?>
                    <i><?php echo CrugeTranslator::t("maxlength = -1 causa que no se valide el tamano de este campo");?></i>
            </div>
        </div>
        
	<div class="row2">
		<div class='input-control textarea span5'>
			<?php echo $form->labelEx($model,'predetvalue'); ?>
			<?php echo $form->textArea($model,'predetvalue',array('rows'=>5,'cols'=>40)); ?>
			<?php echo $form->error($model,'predetvalue'); ?>
			<p class='hint'><?php echo CrugeTranslator::t(
                        "si el fieldtype es un Listbox ponga aqui las opciones una por cada linea,
                         el valor coloquelo al inicio seguido de una coma, ejemplo:
                         <ul style='list-style: none;'>
                         <li>1, azul</li>
                         <li>2, rojo</li>
                         <li>3, verde</li>
                         </ul>
                        "
                        );?></p>
		</div>
	</div>
    </fieldset>
</div>

<div class="example">
    <fieldset>
        <legend>Data Validation</legend>
	<div class='row2'>
            <div class='input-control textarea span5'>
                    <?php echo $form->labelEx($model,'useregexp'); ?>
                    <?php echo $form->textArea($model,'useregexp',array('rows'=>5,'cols'=>40)); ?>
                    <?php echo $form->error($model,'useregexp'); ?>
                    <p class='hint'><?php echo CrugeTranslator::t("dejar en blanco si no se quiere usar");?></p>
            
            <p>
		<?php echo ucfirst(CrugeTranslator::t(
				"La expresion regular (regexp) es una lista de caracteres
				 que validan la sintaxis de lo que el usuario ingrese en este campo.
				 por ejemplo:"
			));
		?>
		<?php
		echo "<br/><u>".CrugeTranslator::t("telefono:")."</u><br/>^([0-9-.+ \(\)]{3,20})$";
		echo "<br/><u>".CrugeTranslator::t("digitos y letras:")."</u><br/>^([a-zA-Z0-9]+)$";
		?>
            </p>
            </div>
	</div>
        <div class='row2'>
            <div class='input-control text span5'>
                    <?php echo $form->labelEx($model,'useregexpmsg'); ?>
                    <?php echo $form->textField($model,'useregexpmsg',array('size'=>50,'maxlength'=>512)); ?>
                    <?php echo $form->error($model,'useregexpmsg'); ?>
            </div>
        </div>
    </fieldset>
</div>



<div class="row buttons center">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('class' => 'primary large', 'name'=>'Submit')); ?>
</div>
<?php echo $form->errorSummary($model); ?>
    
<?php $this->endWidget(); ?>
