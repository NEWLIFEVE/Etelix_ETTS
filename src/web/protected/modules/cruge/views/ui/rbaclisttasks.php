<div class="span9">
    <h2><?php echo ucwords(CrugeTranslator::t("tasks"));?></h2>
    <?php $this->renderPartial('_listauthitems',array('dataProvider'=>$dataProvider),false); ?>
</div>
<div class="span3">
    <h2>New Task</h2>
    <div class='auth-item-create-button'>
    <?php echo CHtml::link(CrugeTranslator::t("Create")
            ,Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_TASK), 
            array('class' => 'enlace'));?>
    </div>
</div>





