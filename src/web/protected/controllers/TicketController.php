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
            
//            if (Yii::app()->user->checkAccess('cliente') || Yii::app()->user->checkAccess('subadmin')) { // Si el rol del usuario es cliente tendrá acceso al ticket information
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
//            } else {
//                throw new CHttpException(401,'No Access');
//            }
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
            $rutaAttachFile = array();
            
             $modelTicket->date=date('Y-m-d');
             $modelTicket->id_failure=$_POST['failure'];
             $modelTicket->id_status=1;
             $modelTicket->id_gmt=$_POST['gmt'];
             $modelTicket->destination_ip=$_POST['destinationIp'];
             $modelTicket->origination_ip=$_POST['originationIp'];
             $modelTicket->prefix=$_POST['prefix'];
             $modelTicket->machine_ip=Yii::app()->request->userHostAddress;
             $modelTicket->id_ticket=NULL;
             $modelTicket->hour=date('H:m:s');
             
             $maxID = Yii::app()->db->createCommand("SELECT MAX(id) AS maximo FROM ticket")->queryRow();
             $max = $maxID['maximo'] + 1;
             $typeUser = '';
             if (Yii::app()->user->checkAccess('cliente')) $typeUser = '-C';
             if (Yii::app()->user->checkAccess('interno')) $typeUser = '-I';
             if (Yii::app()->user->checkAccess('proveedor')) $typeUser = '-P';
             if (Yii::app()->user->checkAccess('admin')) $typeUser = '-A';
//             if (Yii::app()->user->checkAccess('subadmin')) $typeUser = '-SA';
             
             $ticketNumber = date('Ymd') . '-' . $max . $typeUser . $modelTicket->id_failure;
             $modelTicket->ticket_number= $ticketNumber;
             
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
                
                if (isset($_POST['_attachFile']) && count($_POST['_attachFile'])) { // Se verifica si se envia por post
                    // Guardando Attach File
                    for ($i = 0; $i < count($_POST['_attachFile']); $i++){
                        $modelAttachFile = new File;
                        $modelAttachFile->id_ticket = $modelTicket->id;
                        $modelAttachFile->saved_name = $_POST['_attachFileSave'][$i];
                        $modelAttachFile->real_name = $_POST['_attachFile'][$i];
                        $modelAttachFile->size = $_POST['_attachFileSize'][$i];
                        $modelAttachFile->rute = 'uploads/' . $_POST['_attachFileSave'][$i];
                        $rutaAttachFile[] = $modelAttachFile->rute;
                        $modelAttachFile->save();
                    }
                }
                
                // Guardando descripcion
                $modelDescriptionTicket = new DescriptionTicket(); 
                $modelDescriptionTicket->id_ticket = $modelTicket->id;
                $modelDescriptionTicket->description = $_POST['description'];
                $modelDescriptionTicket->date = date('Y-m-d');
                $modelDescriptionTicket->hour = date('H:m:s');
                $modelDescriptionTicket->save();
                
                $mailer = new EnviarEmail;
                
                $cuerpo = 
                '<div style="width:100%">
                        <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                        <hr>
                        <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$ticketNumber.'</div>
                        <div>
                                <h2>Hello "'. Yii::app()->user->name .'"</h2>
                                <p style="text-align:justify">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                        </div>
                        <hr>
                </div>
                <h2>Ticket Details</h2>
                <table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">
			<tr>
			    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">Response to</th>
			</tr>
			<tr>
				<td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $_POST['emails']) .'</td>
			</tr>

			<tr>
			    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Failure</th>
			</tr>
			<tr>
				<td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['failureText'].'</td>
			</tr>

			<tr>
			    <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
			    <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
			</tr>
			<tr>
				<td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['originationIp'].'</td>
				<td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['destinationIp'].'</td>
			</tr>

			<tr>
			    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Prefix</th>
			</tr>
			<tr>
				<td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['prefix'].'</td>
			</tr>

			<tr>
			    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">GMT</th>
			</tr>
			<tr>
				<td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['gmtText'].'</td>
			</tr>


			<tr>
			    <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Tested number</th>
			    <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Country</th>
			    <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Date</th>
			    <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Hour</th>
			</tr>
			<tr>
				<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $_POST['testedNumber']) .'</td>
				<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $_POST['_countryText']) .'</td>
				<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $_POST['_date']) .'</td>
				<td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $_POST['_hour']) .'</td>
			</tr>

			<tr>
			    <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Description</th>
			</tr>
			<tr>
                                <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$_POST['description'].'</td>
			</tr>
		</table>
                <div style="width:100%">
		<p style="text-align:justify">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
                </div>
                ';
                
                $mailer->enviar($cuerpo, $_POST['emails'], '', 'ETTS TICKET TEST', $rutaAttachFile);
                
                echo 'success';
            } else {
                echo 'error';
            }
        }
}
