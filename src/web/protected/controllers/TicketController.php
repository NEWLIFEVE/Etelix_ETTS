<?php

class TicketController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','SaveTicket','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
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
            
            if (Yii::app()->user->checkAccess('cliente') || Yii::app()->user->checkAccess('subadmin')) { // Si el rol del usuario es cliente tendrá acceso al ticket information
		$model=new Ticket;
                /*Instancio los modelos donde se harán inserts*/
                $modelTestedNumbers= new TestedNumber;
                $modelDescripcionTicket= new DescriptionTicket;
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ticket']))
		{
                        
			$model->attributes=$_POST['Ticket'];
                        
                        //Demás atributos que no estan en el formualrio
                        $model->id_status = 1;
                        $model->date = new CDbExpression('NOW()');
                        $model->machine_ip = Yii::app()->request->userHostAddress;
                        
			if($model->save()) {
                               
                                $countDestination = $_POST['Ticket']['country'];
                                $countTestedNumbers = $_POST['Ticket']['tested_numbers'];
                                $countFecha = $_POST['Ticket']['date_number'];
                                
                                for ($i = 0; $i < count($countTestedNumbers); $i++) {
                                    // Guardo en TestedNumbers
                                    $model->addTestedNumbers(
                                            $model->primaryKey, 
                                            $countDestination[$i], 
                                            $countTestedNumbers[$i], 
                                            $countFecha[$i]
                                            );
                                }
                                
                                // Guardo en DescripcionTicket
                                $modelDescripcionTicket->id_ticket = $model->primaryKey;
                                $modelDescripcionTicket->description = $_POST['Ticket']['description'];
                                $modelDescripcionTicket->date = new CDbExpression('NOW()');
                                
                                $modelTestedNumbers->save();
                                $modelDescripcionTicket->save();
                                
				$this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
            } else {
                throw new CHttpException(401,'No Access');
            }
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

		if(isset($_POST['Ticket']))
		{
			$model->attributes=$_POST['Ticket'];
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
		$dataProvider=new CActiveDataProvider('Ticket');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Ticket('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ticket']))
			$model->attributes=$_GET['Ticket'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ticket the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ticket::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ticket $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ticket-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionSaveTicket()
        {
            $modelTicket = new Ticket;
             $modelTicket->date=date('y-m-d');
             $modelTicket->id_failure=$_POST['failure'];
             $modelTicket->id_status=1;
             $modelTicket->id_gmt=$_POST['gmt'];
             $modelTicket->destination_ip=$_POST['destinationIp'];
             $modelTicket->origination_ip=$_POST['originationIp'];
             $modelTicket->prefix=$_POST['prefix'];
             $modelTicket->machine_ip=Yii::app()->request->userHostAddress;
             $modelTicket->id_ticket=NULL;
             $modelTicket->hour=date('H:m:s');
             
             $criteria=new CDbCriteria;
             $criteria->select='max(id) AS maxColumn';
             $row = $modelTicket->model()->find($criteria);
             $maxID = $row['maxColumn'] + 1;
             
             $ticketNumber = date('Ymd') . '-' . $maxID . '-';
             $modelTicket->ticket_number=  uniqid();
             
             
             
             if($modelTicket->save()){
                // Guardando los mails
                for ($i = 0; $i < count($_POST['responseTo']); $i++){
                    $modelMailTicket = new MailTicket;
                    $modelMailTicket->id_mail_user = $_POST['responseTo'][$i];
                    $modelMailTicket->id_ticket = $modelTicket->id;
                    $modelMailTicket->save();
                } 
                
                // Guardando number
                for ($i = 0; $i < count($_POST['testedNumber']); $i++){
                    $modelTestedNumber = new TestedNumber;
                    $modelTestedNumber->id_ticket = $modelTicket->id;
                    $modelTestedNumber->id_country = $_POST['_country'][$i];
                    $modelTestedNumber->numero = $_POST['testedNumber'][$i];
                    $modelTestedNumber->date = $_POST['_date'][$i];
                    $modelTestedNumber->hour = $_POST['_hour'][$i];
                    $modelTestedNumber->save();
                } 
                
                // Guardando descripcion
                $modelDescriptionTicket = new DescriptionTicket(); 
                $modelDescriptionTicket->id_ticket = $modelTicket->id;
                $modelDescriptionTicket->description = $_POST['description'];
                $modelDescriptionTicket->date = date('Y-m-d');
                $modelDescriptionTicket->hour = date('H:m:s');
                $modelDescriptionTicket->save();
                
                $mailer = new EnviarEmail;
                
                for ($i = 0; $i < count($_POST['emails']); $i++)
                    $mailer->enviar('Testing', $_POST['emails'][$i], '', 'ETTS TICKET TEST');
                
                echo 'success';
            } else {
                echo 'error';
            }
        }
}
