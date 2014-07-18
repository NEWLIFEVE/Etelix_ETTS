<?php
	/*
		$model:  es una instancia que implementa a CrugeAuthItemEditor
	*/
	
?>
<h2><?php echo ucwords(CrugeTranslator::t("Edit")." ".CrugeTranslator::t($model->categoria));?></h2>
<?php $this->renderPartial('_authitemform',array('model'=>$model),false);?>