<h2><?php echo ucwords(CrugeTranslator::t("tasks"));?></h2>

<div class='auth-item-create-button'>
<?php echo CHtml::link(CrugeTranslator::t("Crear Nueva Tarea")
	,Yii::app()->user->ui->getRbacAuthItemCreateUrl(CAuthItem::TYPE_TASK));?>
</div>

<?php $this->renderPartial('_listauthitems',array('dataProvider'=>$dataProvider),false);?>
