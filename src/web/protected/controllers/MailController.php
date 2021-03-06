<?php

class MailController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
//	public function filters()
//	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			'postOnly + delete', // we only allow deletion via POST request
//		);
//	}
        
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
				'actions'=>array('create','update','SetMail'),
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
		$model=new Mail;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Mail']))
		{
			$model->attributes=$_POST['Mail'];
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

		if(isset($_POST['Mail']))
		{
			$model->attributes=$_POST['Mail'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            echo $id;
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Mail');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mail('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mail']))
			$model->attributes=$_GET['Mail'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionAutocomplete()
        {
            $mails=Ticket::model()->findAllBySql("SELECT DISTINCT mail FROM mail");
            $data=array();
            if ($mails != null) {
                foreach ($mails as $key => $value) {
                    $data[]=$value->mail;
                }
            }
            echo CJSON::encode($data);
        }

	/**
	 *Guarda los mail relacionados a usuarios y también los mails de los tickets
	 */
	public function actionSetMail()
	{
            $model=new Mail;
            $modelMailUser=new MailUser;

            $idUser=$_POST['user'];
            $option=$_POST['option'];
            
            
            if($option != 'etelix_to_carrier') 
            {
                if(!$modelMailUser::getCountMail($idUser))
                {
                        echo "tope alcanzado";
                        return;
                }
            }

            $existeMail=$model->find("mail=:mail",array(":mail"=>$_POST['mail']));
            if($existeMail!=null)
            {
                $existeMailUser=$modelMailUser->findBySql("SELECT * FROM mail_user WHERE id_user=$idUser AND id_mail=".$existeMail->id." AND status=0");
                if($existeMailUser!=null)
                {
                    $modelMailUser::model()->updateByPk($existeMailUser->id,array("status"=>'1', "assign_by" => $this->_assignBy($option)));
                    echo 'true';
                }
                else
                {
                    if($option == 'etelix_to_carrier')
                    {
                        $existeMailUser2=$modelMailUser->findBySql(
                                "SELECT * FROM mail_user 
                                WHERE id_user=$idUser AND 
                                id_mail=".$existeMail->id." AND 
                                status=1");
                    }
                    else
                    {
                        $existeMailUser2=$modelMailUser->findBySql(
                                "SELECT * FROM mail_user 
                                WHERE id_user=$idUser AND 
                                id_mail=".$existeMail->id." AND 
                                assign_by = 1 AND
                                status=1");
                        if($existeMailUser2!=null)
                        {
                            $modelMailUser::model()->updateByPk($existeMailUser2->id,array("assign_by"=>"0"));
                            echo 'true';
                            return;
                        }
                        
                        $existeMailUser2=$modelMailUser->findBySql(
                                "SELECT * FROM mail_user 
                                WHERE id_user=$idUser AND 
                                id_mail=".$existeMail->id." AND 
                                assign_by = 0 AND
                                status=1");
                    }
                    
                    if($existeMailUser2!=null)
                    {
                        echo 'existe correo';
                    }
                    else
                    {

                        $modelMailUser->id_mail=$existeMail->id;
                        $modelMailUser->id_user=$idUser;
                        $modelMailUser->status=1;
                        $modelMailUser->assign_by=$this->_assignBy($option);
                        if($modelMailUser->save())
                        {
                                if (isset($_POST['idTicket']) && $_POST['idTicket'] != null)
                                { 
                                    if  ($this->_saveMailTicket($_POST['idTicket'], $modelMailUser->id)) 
                                    {
                                        header('Content-type: application/json');
                                        echo CJSON::encode(Mail::getMailsTicket($_POST['idTicket']));
                                    }
                                    else 
                                    {
                                        echo 'false';
                                    }
                                }
                                else
                                {
                                    echo 'true';
                                }
                        }
                        else
                        {
                                echo 'false';
                        }
                    }
                }
            }
            else
            {
                $model->mail=$_POST['mail'];
                if($model->save())
                {
                    $modelMailUser->id_mail=$model->id;
                    $modelMailUser->id_user=$idUser;
                    $modelMailUser->status=1;
                    $modelMailUser->assign_by=$this->_assignBy($option);

                    if($modelMailUser->save())
                    {
                            if (isset($_POST['idTicket']) && $_POST['idTicket'] != null)
                            { 
                                if  ($this->_saveMailTicket($_POST['idTicket'], $modelMailUser->id)) 
                                {
                                    header('Content-type: application/json');
                                    echo CJSON::encode(Mail::getMailsTicket($_POST['idTicket']));
                                }
                                else 
                                {
                                    echo 'false';
                                }
                            }
                            else
                            {
                                echo 'true';
                            }
                    }
                    else
                    {
                            echo 'false';
                    }
                }
            }
            
	}
        
        /**
         * Guardará en la tabla mail_ticket al guardar en mail y mail_user
         * @param int $idticket
         * @param int $idMailUser
         * @return boolean
         */
        private function _saveMailTicket($idticket, $idMailUser)
        {
            $attributes=array('id_ticket'=>$idticket, 'responseTo'=>$idMailUser);
                if (!MailTicket::saveMailTicket($attributes, 1)) 
                    return false;
                else
                    return true;
        }

    /**
     * 
     * @param string $typeUser
     * @return int
     */
    private function _assignBy($optionOpen)
    {
        $assignBy=1;
        
        if ($optionOpen != 'etelix_to_carrier') $assignBy=0;
        
        return $assignBy;
    }
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mail the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mail::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mail $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mail-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
