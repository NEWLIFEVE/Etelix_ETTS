<?php

class MailticketController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        public function filters()
        {
            return array(array('CrugeAccessControlFilter'));
        }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MailTicket;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MailTicket']))
		{
			$model->attributes=$_POST['MailTicket'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MailTicket']))
		{
			$model->attributes=$_POST['MailTicket'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Borra los mails asociados a un ticket
	 */
	public function actionDelete()
	{   
            if (isset($_POST['idMailTicket']) && $_POST['idMailTicket'] != null)
            {
                if (!is_array($_POST['idMailTicket']))
                {
                    $this->loadModel($_POST['idMailTicket'])->delete();
                }
                else
                {
                    $count=count($_POST['idMailTicket']);
                    for ($i=0; $i<$count; $i++) 
                    {
                        $this->loadModel($_POST['idMailTicket'][$i])->delete();
                    }
                }
            }   
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('MailTicket');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MailTicket('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MailTicket']))
			$model->attributes=$_GET['MailTicket'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MailTicket the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MailTicket::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MailTicket $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mail-ticket-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         * Guarda los mails asociados a un ticket específico
         */
        public function actionSavemailticket()
        {   
            $attributes=array('id_ticket'=>$_POST['idTicket'], 'responseTo'=>$_POST['mail']);
            if (!MailTicket::saveMailTicket($attributes, 1)) 
                echo 'false';
            else
                echo CJSON::encode(Mail::getMailsTicket($_POST['idTicket']));
        }
}
