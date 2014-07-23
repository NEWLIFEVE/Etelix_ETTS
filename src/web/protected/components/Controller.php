<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
        /**
        * Antes de que se ejecute una acción
        */
        public function beforeAction($action) 
        {
            //Yii::log(__METHOD__ . ' isGuest: ' . (Yii::app()->getUser()->isGuest ? 'Si' : 'No'));

            // Cada vez que se ejecuta una acción se actualiza el tiempo de expiración
            // TODO: integrar con cruge o mejorar
            $sys = Yii::app()->user->um->getDefaultSystem();
            $duration = $sys->getn('sessionmaxdurationmins');
            // Encuentra la última sesión y actualiza la fecha de expiración
            $model = CrugeSession::model()->findLast(Yii::app()->user->id);
            if ($model != null) {
                $model->expire = CrugeUtil::makeExpirationDateTime($duration);
                $model->save();
            }

            return true;
        }
}