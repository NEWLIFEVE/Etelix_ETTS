<?php
/** 
 *
 */
class TicketController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @access public
	 * @return array
	 */
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
		$this->render('create',array(
			'model'=>$model
		));
	}

	/**
	 *
	 */
	public function actionCreateinternal()
	{
		$model=new Ticket;
		$this->render('createinternal',array(
			'model'=>$model
		));
	}
        
        /**
	 *
	 */
	public function actionCreatetoclient()
	{
		$model=new Ticket;
		$this->render('createtoclient',array(
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

	/**
	 *
	 */
	public function actionSaveticket()
	{
            date_default_timezone_set('America/Caracas');

            $modelTicket=new Ticket;
                    $rutaAttachFile=array();
            $idUser=null;
            
            $typeUser='C';
            
                if (isset($_POST['typeUser'])) 
                    $typeUser=$this->_getTypeUser($_POST['typeUser']);
                
		$modelTicket->date=date('Y-m-d');
		$modelTicket->id_failure=$_POST['failure'];
		$modelTicket->destination_ip=$_POST['destinationIp'] == '' ? null: $_POST['destinationIp'];
		$modelTicket->origination_ip=$_POST['originationIp'] == '' ? null: $_POST['originationIp'];
		$modelTicket->prefix=$_POST['prefix'];
		$modelTicket->machine_ip=Yii::app()->request->userHostAddress;
		$modelTicket->hour=date('H:i:s');
		$maximo=$modelTicket::model()->findBySql("SELECT COUNT(id) AS number_of_the_day FROM ticket WHERE date= '".date('Y-m-d')."'");
		$maximo->number_of_the_day+=1;
		$ticketNumber=date('Ymd').'-'.str_pad($maximo->number_of_the_day, 3, "0", STR_PAD_LEFT).'-'.$typeUser.$modelTicket->id_failure;
		$modelTicket->ticket_number=$ticketNumber;

        $modelTicket->id_user=Yii::app()->user->id;
        $modelTicket->id_status=1;
        if(isset($_POST['isInternal']) && $_POST['isInternal'] == '1')
        {
            $modelTicket->id_gmt=null;
            if(!$modelTicket->save())
            {
                echo '<h2>Ticket</h2>';
                print_r($modelTicket->getErrors());
            }
        }
        else
        {
            $modelTicket->id_gmt=$_POST['gmt'];
            if(!$modelTicket->save())
            {
                echo '<h2>Ticket</h2>';
                print_r($modelTicket->getErrors());
            }
                    
            // Guardando number
            $number=count($_POST['testedNumber']);
            for($i=0; $i<$number; $i++)
            {
                $modelTestedNumber=new TestedNumber;
                $modelTestedNumber->id_ticket=$modelTicket->id;
                $modelTestedNumber->id_country=$_POST['_country'][$i];
                $modelTestedNumber->numero=$_POST['testedNumber'][$i];
                $modelTestedNumber->date=$_POST['_date'][$i];
                $modelTestedNumber->hour=$_POST['_hour'][$i];
                if(!$modelTestedNumber->save())
                {
                    echo '<h2>Tested Number</h2>';
                    print_r($modelTestedNumber->getErrors());
                }
            }
        }
                
        // Guardando los mails (to)
        if (isset($_POST['responseTo']) && $_POST['responseTo'] != null)
        {
            $responseTo=count($_POST['responseTo']);
            for($i=0; $i<$responseTo; $i++)
            {
                $modelMailTicket=new MailTicket;
                $modelMailTicket->id_mail_user=$_POST['responseTo'][$i];
                $modelMailTicket->id_ticket=$modelTicket->id;
                $modelMailTicket->id_type_mailing=1;
                if (!$modelMailTicket->save())
                {
                    echo '<h2>Mail Ticket (to)</h2>';
                    print_r($modelMailTicket->getErrors());
                }
            }
        }

        // Guardando los mails (cc)
        if(isset($_POST['cc']) && $_POST['cc'] != null)
        {
            $cc=count($_POST['cc']);
            for($i=0; $i<$cc; $i++)
            {
                $modelMailTicket=new MailTicket;
                $modelMailTicket->id_mail_user=$_POST['cc'][$i];
                $modelMailTicket->id_ticket=$modelTicket->id;
                $modelMailTicket->id_type_mailing=2;
                if (!$modelMailTicket->save())
                {
                    echo '<h2>Ticket (cc)</h2>';
                    print_r($modelMailTicket->getErrors());
                }
            }
        }

        // Guardando los mails (bbc)
        if (isset($_POST['bbc']) && $_POST['bbc'] != null)
        {
            $bbc=count($_POST['bbc']);
            for($i=0; $i<$bbc; $i++)
            {
                $modelMailTicket=new MailTicket;
                $modelMailTicket->id_mail_user=$_POST['bbc'][$i];
                $modelMailTicket->id_ticket=$modelTicket->id;
                $modelMailTicket->id_type_mailing=3;
                if (!$modelMailTicket->save())
                {
                    echo '<h2>Ticket (bcc)</h2>';
                    print_r($modelMailTicket->getErrors());
                }
            }
        }
                
        // Guardando descripcion
        $modelDescriptionTicket=new DescriptionTicket();
        $modelDescriptionTicket->id_ticket=$modelTicket->id;
        $modelDescriptionTicket->description=$_POST['description'];
        $modelDescriptionTicket->date=date('Y-m-d');
        $modelDescriptionTicket->hour=date('H:i:s');
        $modelDescriptionTicket->id_user=Yii::app()->user->id;
        $modelDescriptionTicket->read=0;
        if (!$modelDescriptionTicket->save())
        {
            echo '<h2>Description</h2>';
            print_r($modelDescriptionTicket->getErrors());
        }
                
        if(isset($_POST['_attachFile']) && count($_POST['_attachFile']))
        {
            /**
             * Se verifica si se envia por post
             * Guardando Attach File
             */
            $file=count($_POST['_attachFile']);
            for($i=0; $i<$file; $i++)
            {
                $modelAttachFile=new File;
                $modelAttachFile->id_ticket=$modelTicket->id;
                $modelAttachFile->saved_name=$_POST['_attachFileSave'][$i];
                $modelAttachFile->real_name=$_POST['_attachFile'][$i];
                $modelAttachFile->size=$_POST['_attachFileSize'][$i];
                $modelAttachFile->rute='uploads/'.$_POST['_attachFileSave'][$i];
                $modelAttachFile->id_description_ticket=$modelDescriptionTicket->id;
                $rutaAttachFile[]=$modelAttachFile->rute;
                if (!$modelAttachFile->save())
                {
                    echo '<h2>Attach File</h2>';
                    print_r($rutaAttachFile->getErrors());
                }
            }
        }

        // Variables para enviar al cuerpo del correo
        $cuerpo='';
        $cuerpo_tt='';
        // to, cc y bbc si es enviado por el supplier
        $to=array();
        $bbc=null;
        $cc=null;
        
        $cuerpoMail=new CuerpoCorreo();
                
        // Si es interntal
        if (isset($_POST['isInternal']) && $_POST['isInternal'] == '1')
        {
            if (isset($_POST['emails']) && $_POST['emails'] != null) $to = $_POST['emails'];
            if (isset($_POST['direccionCC']) && $_POST['direccionCC'] != null) $cc = $_POST['direccionCC'];
            if (isset($_POST['direccionBBC']) && $_POST['direccionBBC'] != null) $bbc = $_POST['direccionBBC'];
            
            $cuerpoMail->init(
                        $ticketNumber,
                        Yii::app()->user->name,
                        $_POST['emails'],
                        $_POST['failureText'],
                        $_POST['originationIp'],
                        $_POST['destinationIp'],
                        $_POST['prefix'],
                        null,
                        array(),
                        array(),
                        array(),
                        array(),
                        $_POST['description'],
                        $cc,
                        $bbc,
                        $_POST['speech']
                    );
            $cuerpo=$cuerpoMail->getBodySupplier();
        }
        // Si es cliente
        else
        {
            $user=Yii::app()->user->name;
            if (isset($_POST['user']) && isset($_POST['idUser']) && $_POST['user'] != null && $_POST['idUser'] != null)
            {
                $user=$_POST['user'];
                $idUser=$_POST['idUser'];
            }
            
            $cuerpoMail->init(
                        $ticketNumber,
                        $user,
                        $_POST['emails'],
                        $_POST['failureText'],
                        $_POST['originationIp'],
                        $_POST['destinationIp'],
                        $_POST['prefix'],
                        $_POST['gmtText'],
                        $_POST['testedNumber'],
                        $_POST['_countryText'],
                        $_POST['_date'],
                        $_POST['_hour'],
                        $_POST['description']
                    );
            
            $cuerpo=$cuerpoMail->getBodyCustumer();
            $cuerpo_tt=$cuerpoMail->getBodyTT();
            
            $to=$_POST['emails']; 
        }
                
        $mailer=new EnviarEmail; 
        
        $nameCarrier=Carrier::getCarriers(true, $modelTicket->id);
        $tipoUsuario='';
        if ($idUser === null)
        {
            $tipoUsuario = CrugeAuthassignment::getRoleUser();
        }
        else
        {
            $tipoUsuario = CrugeAuthassignment::getRoleUser(false, $idUser);
        }
        
        $subject='';
        if ($tipoUsuario == 'C')
        {
            $subject='TT from '.$nameCarrier.', New TT, '.$ticketNumber.'';
        }
        else
        {
            $subject='TT for '.$nameCarrier.', New TT, '.$ticketNumber.'';
        }
                
        $envioMail=$mailer->enviar($cuerpo, $to,'',$subject,$rutaAttachFile,$cc);
        
        if($envioMail===true)
        {
            echo 'success';
        }
        else
        {
            echo 'Error al enviar el correo: '.$envioMail;
        }
    }
    
    /**
     * Método para retornar la letra que llevará el número del ticket dependiendo
     * de lo que seleccione en el select de la interfaz. Si la interfaz es de un
     * cliente se retornará 'C' por defecto
     *  
     * @param string $key
     * @return string|null
     */
    private function _getTypeUser($key)
    {   
        if ($key != null)
        {
            if ($key == 'customer') 
                return 'C';
            else
                return 'P';
        }
        return 'C';
    }


     /**
     * Action para actualizar el status del ticket. Si el ticket padre está
     * en la tabla "ticket_relation", se actualizaran sus tickets hijos al 
     * status que sea seleccionado, si no se encuentra en dicha tabla, solo 
     * se modificara en la tabla del ticket
     * @param int $id
     */
    public function actionUpdatestatus($id)
    {
    	$idTickets=Ticketrelation::getTicketRelation($id,true);
    	$statuName=Status::getStatus(true,$_POST['idStatus'])->name;
    	$ticketNumber=Ticket::model()->findByPk($id)->ticket_number;
        $body=self::getBodyMails($id,Mail::getNameMails($id),'status',$statuName);

        $mailer=new EnviarEmail;
        $ticketModel = new Ticket;
        $mailModel = new Mail;

        if($idTickets!=null)
        {
        	$ticketSon=self::getTicketsSon($idTickets);
        	$ticketSon[]=$id;
        	$ticketModel::model()->updateAll(array('id_status'=>$_POST['idStatus']),'id in('.implode(",",$ticketSon).')');
        }
        else
        {
        	$ticketModel::model()->updateByPk($id,array('id_status'=>$_POST['idStatus']));
        }

        
        $nameCarrier=Carrier::getCarriers(true, $id);
        
        $tipoUsuario=CrugeAuthassignment::getRoleUser();
        $subject='';
        if ($tipoUsuario == 'C')
        {
            $subject='TT from '.$nameCarrier.', New Status, '.$ticketNumber.'';
        }
        else
        {
            $subject='TT for '.$nameCarrier.', New Status, '.$ticketNumber.'';
        }
        
        $envioMail=$mailer->enviar($body,$mailModel::getNameMails($id),'',$subject,null);

        if($envioMail===true)
        	echo 'true';
        else
        	echo 'Error al enviar el correo: ' . $envioMail;
    }


    /**
     * Método para retornar los tickets hijos de la tabla ticket_relation
     * @param Ticketrelation $idTickets
     * @return array
     */
    public static function getTicketsSon($idTickets) 
    {
        $ticketSon = array();
        foreach ($idTickets as $value) {
            $ticketSon[] = $value->id_ticket_son;
        }
        return $ticketSon;
    }
        
    /**
     * Action para retornar los datos del ticket por su id
     * @param int $id
     */
    public function actionGetdataticket($id)
    {
        $this->renderPartial('_dataticket', array('datos' => Ticket::ticketsByUsers(Yii::app()->user->id, $id, false)));
    }
        
    
    
    /**
     * Método para retornar el cuerpo del mail al cambiar el status del ticket o
     * al dar una respuesta
     * 
     * @param type $idTicket
     * @param type $email
     * @param type $typeOperation
     * @param type $status
     * @return string
     */
    public static function getBodyMails($idTicket,$email,$typeOperation,$status=false)
    {
    	$datos=Ticket::ticketsByUsers(CrugeUser2::getUserTicket($idTicket,true)->iduser,$idTicket,false);

    	$user=CrugeUser2::getUserTicket($idTicket);
    	$testedNumber=TestedNumber::getTestedNumberArray($idTicket);
    	$info='';

    	$header='<div style="width:100%">
    				<img src="http://deve.sacet.com.ve/images/logo.jpg" height="100"/>
    				<hr>
    				<div style="text-align:right">Ticket Confirmation<br>Ticket #: '.$datos->ticket_number.'</div>';
            
        switch($typeOperation)
        {
        	
            // Al cambiar de status
            case 'status':
            	$info='<div>
            			<h2>Hello "'.$user.'"</h2>
            			<p style="text-align:justify">
            				<div>Dear Customer:</div>
            				<br/>
            				<div>Change status: "'. $status .'"</div>
            				<br/>
            				Etelix NOC Team.
            			</p>
            		   </div>
            		   <hr>
                    </div>';
                break;
            // Al responder la descripcion
            case 'answer':
            	$info='<div>
            			<h2>Hello "'.$user.'"</h2>
            			<p style="text-align:justify">
            				<div>Dear Customer:</div>
                            <br/>
                            <div>There is a new message related to your TT</div>
                            <br/>
                            Etelix NOC Team.
                        </p>
                      </div>
                      <hr>
                     </div>';
                break;
            default:
            	break;
    	}

    	$detail='<h2>Ticket Details</h2>
    			 <table style="border-spacing: 0; width:100%; border: solid #ccc 1px;">
    			 	<tr>
    			 		<th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc; padding: 5px 10px; text-align: left;">Response to</th>
    			 	</tr>
    			 	<tr>
    			 		<td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'. implode('<br>', $email) .'</td>
    			 	</tr>
    			 	<tr>
    			 		<th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Failure</th>
			        </tr>
			        <tr>
			                <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$datos->idFailure->name.'</td>
			        </tr>

			        <tr>
			            <th colspan="1" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Origination IP</th>
			            <th colspan="3" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Destination IP</th>
			        </tr>
			        <tr>
			                <td colspan="1" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$datos->origination_ip.'</td>
			                <td colspan="3" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$datos->destination_ip.'</td>
			        </tr>
		            <tr>
		                <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Prefix</th>
		            </tr>
		            <tr>
		                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$datos->prefix.'</td>
		            </tr>';
        if(isset($datos->idGmt->name))
        {
		    $detail.='<tr>
		                <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">GMT</th>
		              </tr>
		              <tr>
                        <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.$datos->idGmt->name.'</td>
                    </tr>';
        }
        if(isset($testedNumber['number']))
        {
            $detail.='<tr>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Tested number</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Country</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Date</th>
                        <th style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Hour</th>
                      </tr>
                      <tr>
                        <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.implode('<br>', $testedNumber['number']).'</td>
	                    <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.implode('<br>', $testedNumber['country']).'</td>
	                    <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.implode('<br>', $testedNumber['date']).'</td>
	                    <td style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.implode('<br>', $testedNumber['hour']).'</td>
		            </tr>';
        }
		
        $detail.='<tr>
		                <th colspan="4" style="color: #ffffff !important; background-color: #16499a !important; border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">Description</th>
		            </tr>
		            <tr>
		                    <td colspan="4" style=" border-left: 1px solid #ccc; border-top: 1px solid #ccc;padding: 5px 10px; text-align: left;">'.  DescriptionTicketController::getDescription($idTicket, $datos).'</td>
		            </tr>
		            </table>';
        $footer = '<div style="width:100%">
                        <p style="text-align:justify">
                            <br/>
                            <div style="font-style:italic;">Please do not reply to this email. Replies to this message are routed to an unmonitored mailbox.</div>
                        </p>
                   </div>';
		return $header.$info.$detail.$footer;
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
    
    public function actionCarriersbyclass()
    {
        header("Content-type: application/json");
        echo CJSON::encode(CrugeUser2::getCarriersSupplierOrCustomer($_POST['_type']));
    }
}
