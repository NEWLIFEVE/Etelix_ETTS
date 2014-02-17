<?php

class DescriptionticketController extends Controller
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
		$model=new DescriptionTicket;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DescriptionTicket']))
		{
			$model->attributes=$_POST['DescriptionTicket'];
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

		if(isset($_POST['DescriptionTicket']))
		{
			$model->attributes=$_POST['DescriptionTicket'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DescriptionTicket');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DescriptionTicket('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DescriptionTicket']))
			$model->attributes=$_GET['DescriptionTicket'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DescriptionTicket the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DescriptionTicket::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DescriptionTicket $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='description-ticket-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    /**
     * Action para salvar la descripción o respuesta que se de en el preview
     * del ticket
     */
    public function actionSavedescription()
    {
    	if(isset($_POST['idTicket']))
    	{
    		$mailer=new EnviarEmail;
    		$speech=null;
    		if(isset($_POST['idSpeech'])) $speech=$_POST['idSpeech'];
                //Guardar Description
    		$model=new DescriptionTicket;
    		$model->id_ticket=$_POST['idTicket'];
    		$model->description=$_POST['message'];
    		$model->date=date('Y-m-d');
    		$model->hour=date('H:i:s');
    		$model->id_speech=$speech;
    		$model->id_user=Yii::app()->user->id;
    		$model->read=0;
    		if($model->save())
    		{
	            /**
	            * Se verifica si se envia por post
	            * Guardando Attach File
	            */
	            if(isset($_POST['files']) && count($_POST['files']) && !empty($_POST['files']))
	            {
                        $count=count($_POST['files']);
                        for($i=0; $i<$count; $i++)
                        {
                            $modelAttachFile=new File;
                            $modelAttachFile->id_ticket=$model->id_ticket;
                            $modelAttachFile->saved_name=$_POST['fileServer'][$i];
                            $modelAttachFile->real_name=$_POST['files'][$i];
                            $modelAttachFile->size=0.0;
                            $modelAttachFile->rute='uploads/'.$_POST['fileServer'][$i];
                            $modelAttachFile->id_description_ticket=$model->id;
                            $modelAttachFile->save();
                        }
                    }
                    
                    $ticketNumber=Ticket::model()->findByPk($model->id_ticket)->ticket_number;
                    //Renderizar para mostrar la repsuesta
                    $this->renderPartial('/ticket/_answer', array('datos' => Ticket::ticketsByUsers(Yii::app()->user->id, $model->id_ticket, false)));

                    $mailsAll=Mail::getNameMails($model->id_ticket);
                    $nameCarrier=Carrier::getCarriers(true, $model->id_ticket);
                    $tipoUsuario = CrugeAuthassignment::getRoleUser();
                    $subject='';
                    if($tipoUsuario=='C')
                    {
                            $subject='TT from '.$nameCarrier.', New Answer, '.$ticketNumber.'';
                    }
                    else
                    {
                            $subject='TT for '.$nameCarrier.', New Answer, '.$ticketNumber.'';
                    }
                    $mailer->enviar(TicketController::getBodyMails($model->id_ticket, Mail::getNameMails($model->id_ticket), 'answer'), $mailsAll, '', $subject);
        	}
	    	else
                {
                    echo 'false';
                }
        }
    }
    
    /**
     * 
     * @param int $idTicket
     * @param array $datos
     * @return string
     */  
    public static function getDescription($idTicket, $datos)
    {
        $user=CrugeUser2::getUserTicket($idTicket, true)->iduser;
        $areaAnswer = '<div style="margin: 10px auto !important; 
                                   border-top:1px #d9d9d9 solid;
                                   border-bottom:1px #d9d9d9 solid;
                                   border-left:1px #d9d9d9 solid;
                                   min-height:60px!important;
                                   max-height:210px!important;
                                   overflow:auto;
                                   overflow-y:scroll;
                                   padding:10px;
                                   width:95%;
                                   margin:5px 0 10px 0;
                                   font-size:12px!important">';
        foreach ($datos->descriptionTickets as $value) {
            if($value->idUser !==null){
                if ($value->idUser->iduser === $user) {
                    $float = 'float: left; color: #3e454c; background: rgba(209, 205, 218, 0.5);';
                } else {
                    $float = 'float: right; color: #fff; background: #6badf6;';
                }
                $areaAnswer .= '<div style="border: 1px solid #dfdfdf;
                                    border: 1px solid rgba(0, 0, 0, .18);
                                    border-bottom-color: rgba(0, 0, 0, .29);
                                    -webkit-box-shadow: 0 1px 0 #dce0e6;
                                    line-height: 1.28;
                                    margin: 5px 5px 8px 0;
                                    min-height: 14px;
                                    padding: 4px 5px 3px 6px;
                                    position: relative;
                                    text-align: left;
                                    white-space: pre-wrap;
                                    word-wrap: break-word;
                                    min-width: 20%;
                                    max-width: 100%;
                                    clear: both; '.$float.'">' . 
                        $value->description . '   <br><strong>Date: </strong>' . $value->date . ' || <strong>Hour: </strong>' . $value->hour . ' || <strong>User: </strong>' . $value->idUser->username .  
                     '</div>';   
            } 
        }
        $areaAnswer .= '</div>';
        return $areaAnswer;
    }  
}