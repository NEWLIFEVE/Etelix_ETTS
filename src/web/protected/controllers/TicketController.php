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
			'model'=>$model
		));
	}
        
        
        
        
        public function actionCreateinternal()
	{
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

		$this->render('createinternal',array(
			'model'=>$model
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
        
        public function actionSaveticket()
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
             $modelTicket->hour=date('H:m:s');
             
             $maximo = $modelTicket::model()->findBySql("SELECT MAX(id) AS maximo FROM ticket");
             $maximo->maximo += 1;
             
             $ticketNumber = date('Ymd') . '-' . $maximo->maximo . '-' . CrugeAuthassignment::getRoleUser() . $modelTicket->id_failure;
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
                $modelDescriptionTicket->idSpeech = null;
                $modelDescriptionTicket->id_user = Yii::app()->user->id;
                $modelDescriptionTicket->save();
                
                $mailer = new EnviarEmail;
                
                $header = 
                '<div style="width:100%">
                        <img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
                        <hr>
                        <div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$ticketNumber.'</div>
                ';
                 $info = '  <div>
                                <h2>Hello "'. Yii::app()->user->name .'"</h2>
                                <p style="text-align:justify">
                                    <div>Dear Customer:</div><br/>

                                    <div>Thanks for using our online tool "Etelix Trouble Ticket System" (etts.etelix.com).<br/>

                                    Your issue has been opened with the TT Number (please see below).<br/>

                                    Your TT will be answered by an Etelix Analyst soon.</div><br/>

                                    Etelix NOC Team.    
                                </p>
                        </div>
                        <hr>
                </div>';
                 
                 $info_tt = '  <div>
                                <h2>Hello</h2>
                                <p style="text-align:justify">
                                    You have a new ticket from <h2>"'. Yii::app()->user->name .'"</h2>
                                </p>
                        </div>
                        <hr>
                </div>';
                 
                $detail = '<h2>Ticket Details</h2>
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
		</table>';
                
                $footer = '<div style="width:100%">
		<p style="text-align:justify">
                    <br/><div style="font-style:italic;">Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.</div>
		</p>
                </div>
                ';

                $footer_tt = '<div style="width:100%">
		<p style="text-align:justify">
                    <br/><div style="font-style:italic;">Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.</div>
		</p>
                </div>
                ';
                
                $cuerpo = $header.$info.$detail.$footer;
                $cuerpo_tt = $header.$info_tt.$detail.$footer_tt;
                
                $envioMail = $mailer->enviar($cuerpo, $_POST['emails'],'', $ticketNumber, $rutaAttachFile);
//                $emailsTT[] = 'tt@etelix.com';
                $emailsTT[] = 'tsu.nelsonmarcano@gmail.com';
                $envioMail2 = $mailer->enviar($cuerpo_tt, $emailsTT,  $_POST['emails'], $ticketNumber, $rutaAttachFile);

                if ($envioMail === true) {
                    if ($envioMail2 === true) {
                        echo 'success';
                    } else {
                        echo 'success';
                    }
                } else {
                    echo 'Error al enviar el correo: ' . $envioMail;
                }
            } else {
                echo 'Error al enviar el ticket';
            }
        }
        
        
        /**
         * Action para actualizar el status del ticket. Si el ticket padre está
         * en la tabla "ticket_relation", se actualizaran sus tickets hijos al 
         * status que sea seleccionado, si no se encuentra en dicha tabla, solo 
         * se modificara en la tabla del ticket
         */
        public function actionUpdatestatus($id)
        {
            $idTickets = Ticketrelation::getTicketRelation($id, true);
            
            if ($idTickets != null) {
                $ticketSon = array();
                foreach ($idTickets as $value) {
                    $ticketSon[] = $value->id_ticket_son;
                }
                $ticketSon[] = $id;
                Ticket::model()->updateAll(array('id_status'=>$_POST['idStatus']), 'id in('.implode(",", $ticketSon).')');
            } else {
                Ticket::model()->updateByPk($id, array('id_status' => $_POST['idStatus']));
            }
        }
        
        public function actionGetdataticket($id)
        {
            $this->renderPartial('_dataticket', array('datos' => Ticket::ticketsByUsers(Yii::app()->user->id, $id, false)));
        }
        
        /**
         * Action para retornar los tickets relacionados codificados en json
         * @param int $id
         */
        public function actionGetticketrelation($id)
        {
        	$array=null;
        	foreach (Ticket::ticketsRelations($id) as $key => $value)
        	{
        		$array[$key]['id_ticket']=$value->id;
        		$array[$key]['user']=CrugeUser2::getUserTicket($value->id);
        		$array[$key]['carrier']=Carrier::getCarriers(true, $value->id);
        		$array[$key]['ticket_number']=$value->ticket_number;
        		$array[$key]['failure']=$value->idFailure->name;
        		$array[$key]['status_ticket']=$value->idStatus->name;
        		$array[$key]['origination_ip']=$value->origination_ip;
        		$array[$key]['destination_ip']=$value->destination_ip;
        		$array[$key]['date']=$value->date;
        	}
            echo json_encode($array);
        }
        
        
}
