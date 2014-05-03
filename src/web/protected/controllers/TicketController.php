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
        $typeCarrier='';
        if (Carrier::getTypeCarrier(Yii::app()->user->id) !== false) 
            $typeCarrier=Carrier::getTypeCarrier(Yii::app()->user->id);
        
        $this->render('create',array(
            'model'=>$model,
            'typeCarrier'=>$typeCarrier
        ));
    }

    /**
     * Action encargada de crear tickets Etelix a Carrier
     */
    public function actionCreatetocarrier()
    {
        $model=new Ticket;
                
        $this->render('createtocarrier',array(
            'model'=>$model
        ));
    }
        
    /**
     * Action encargada de crear un ticket a Etelix como un carrier (cliente/proveedor) desde Etelix
     */
    public function actionCreateascarrier()
    {
        $model=new Ticket;
        $this->render('createascarrier',array(
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
        $colors=$this->_countColorsTicket();
        $color = '';
        $this->render('admin',array(
            'colors'=>$colors,
            'color'=>$color,
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
        $modelTicket=new Ticket;
        $typeUser='C';
        if (isset($_POST['typeUser'])) $typeUser=$this->_getTypeUser($_POST['typeUser']);

        $isOk=true;
        $transaction=Yii::app()->db->beginTransaction();

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
        $modelTicket->option_open=$_POST['optionOpen'];
        $modelTicket->close_ticket=null;
        if($modelTicket->option_open == 'etelix_to_carrier')
        {
            $modelTicket->id_gmt=null;
            if (!$modelTicket->save()) $isOk=false;
        }
        else
        {
            $modelTicket->id_gmt=$_POST['gmt'];
            if (!$modelTicket->save()) $isOk=false;
        }
        
        // Guardando number
        $attributes=array(
            'id_ticket'=>$modelTicket->id, 
            '_country'=>$_POST['_country'],
            'testedNumber'=>$_POST['testedNumber'],
            '_date'=>$_POST['_date'],
            '_hour'=>$_POST['_hour']
            );
        if (!TestedNumber::saveTestedNumbers($attributes)) $isOk=false;
        
        // Guardando los mails (to)
        if (isset($_POST['responseTo']) && $_POST['responseTo'] != null)
        {
            $attributes=array('id_ticket'=>$modelTicket->id, 'responseTo'=>$_POST['responseTo']);
            if (!MailTicket::saveMailTicket($attributes, 1)) $isOk=false;
        }

        // Guardando los mails (cc)
        if(isset($_POST['cc']) && $_POST['cc'] != null)
        {
            $attributes=array('id_ticket'=>$modelTicket->id, 'responseTo'=>$_POST['cc']);
            if (!MailTicket::saveMailTicket($attributes, 2)) $isOk=false;
        }

        // Guardando los mails (bbc)
        if (isset($_POST['bbc']) && $_POST['bbc'] != null)
        {
            $attributes=array('id_ticket'=>$modelTicket->id, 'responseTo'=>$_POST['bbc']);
            if (!MailTicket::saveMailTicket($attributes, 3)) $isOk=false;
        }

        // Guardando descripcion
        $attributes=array('id_ticket'=>$modelTicket->id, 'description'=>$_POST['description']);
        $attributtesFile=null;
        $rutaAttachFile=array();
        
        if(isset($_POST['_attachFile']) && count($_POST['_attachFile'])){
            $attributtesFile=array(
                'id_ticket'=>$modelTicket->id,
                '_attachFileSave'=>$_POST['_attachFileSave'],
                '_attachFile'=>$_POST['_attachFile'],
                '_attachFileSize'=>$_POST['_attachFileSize']
            );
            $sizeof=count($_POST['_attachFileSave']);
            for($i=0; $i<$sizeof; $i++) $rutaAttachFile[]='uploads/'.$_POST['_attachFileSave'][$i];
        }
        
        if (!DescriptionTicket::saveDescription($attributes, $_POST['optionOpen'],$attributtesFile)) $isOk=false;
       
        if ($isOk == true)
        {
            $transaction->commit();
            $to=array();
            $bbc=null;
            $cc=null;

            $cuerpoCorreo=new CuerpoCorreo(self::getTicketAsArray($modelTicket->id));
            $cuerpo=$cuerpoCorreo->getBodyOpenTicket($_POST['optionOpen']);

            if (isset($_POST['emails']) && $_POST['emails'] != null) $to = $_POST['emails'];
            if (isset($_POST['direccionCC']) && $_POST['direccionCC'] != null) $cc = $_POST['direccionCC'];
            if (isset($_POST['direccionBBC']) && $_POST['direccionBBC'] != null) $bbc = $_POST['direccionBBC'];

            $mailer=new EnviarEmail; 
            $asunto=new Subject;

            $subject=$asunto->subjectOpenTicket($ticketNumber, Carrier::getCarriers(true, $modelTicket->id), $_POST['optionOpen']);
            $envioMail=$mailer->enviar($cuerpo, $to,'',$subject,$rutaAttachFile,$cc);

            if($envioMail===true)
                echo 'success';
            else
                echo 'Error al enviar el correo: '.$envioMail;
        }
        else
        {
            $transaction->rollBack();
            echo 'Error';
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
                return 'S';
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
        $hour=Ticket::model()->findByPk($id)->hour;
        $date=Ticket::model()->findByPk($id)->date;

        $mailer=new EnviarEmail;
        $ticketModel = new Ticket;
        $mailModel = new Mail;

        if($idTickets!=null)
        {
            $ticketSon=self::getTicketsSon($idTickets);
            $ticketSon[]=$id;
            $ticketModel::model()->updateAll(array('id_status'=>$_POST['idStatus'], 'close_ticket'=>date('Y-m-d H:i:s')),'id in('.implode(",",$ticketSon).')');
        }
        else
        {
            $ticketModel::model()->updateByPk($id,array('id_status'=>$_POST['idStatus'], 'close_ticket'=>date('Y-m-d H:i:s')));
        }
        
        $rutaAttachFile=array();        
        if (isset($_POST['message']) && $_POST['message'] != null) {
            // Guardando descripcion
            $attributes=array('id_ticket'=>$id, 'description'=>$_POST['message']);
            $attributtesFile=null;
            
            if(isset($_POST['files']) && count($_POST['files'])){
                $attributtesFile=array(
                    'id_ticket'=>$id,
                    '_attachFileSave'=>$_POST['fileServer'],
                    '_attachFile'=>$_POST['files'],
                    '_attachFileSize'=>'0.0'
                );
                $sizeof=count($_POST['files']);
                for($i=0; $i<$sizeof; $i++) $rutaAttachFile[]='uploads/'.$_POST['fileServer'][$i];
            }
            
            $internalAsCarrier=null;
            if (isset($_POST['internalAsCarrier']) && $_POST['internalAsCarrier'] != null) $internalAsCarrier='etelix_as_carrier';
            
            DescriptionTicket::saveDescription($attributes,$internalAsCarrier,$attributtesFile);
        }
        
        $asunto=new Subject;
        $cuerpoCorreo=new CuerpoCorreo(self::getTicketAsArray($id));
        
        $body=$cuerpoCorreo->getBodyCloseTicket($statuName);
        $subject=$asunto->subjectCloseTicket($ticketNumber, Carrier::getCarriers(true, $id), Utility::restarHoras($hour, date('H:i:s'), floor(Utility::getTime($date, $hour)/ (60 * 60 * 24))));
        
        $envioMail=$mailer->enviar($body,$mailModel::getNameMails($id),'',$subject,$rutaAttachFile);

        if($envioMail===true)
            $this->renderPartial('/ticket/_answer', array('datos' => Ticket::ticketsByUsers(CrugeUser2::getUserTicket($id, true)->iduser, $id, false, false, true)));
        else
            echo 'false';
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
        $this->renderPartial('_dataticket', array('datos' => Ticket::ticketsByUsers(Yii::app()->user->id, $id, false, true, true)));
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
    
    public function actionAdminclose()
    {
        $colors=$this->_countColorsTicket();
        $color = '';
        $this->render('adminclose',array(
            'colors'=>$colors,
            'color'=>$color,
            ));
    }
    
    /**
     *
     */
    public function actionGetmailsimap()
    {
        if(isset($_POST['ticketNumber']) && !empty($_POST['ticketNumber']))
        {
            error_reporting(E_ALL & ~E_NOTICE); 
            $imap=new Imap();
            $mails=$imap->messageByTicketNumber($_POST['ticketNumber']);
            if($mails != false)
            {
                $imap->deleteMessage($mails,true);
                $this->renderPartial('/ticket/_answer', array('datos' => Ticket::ticketsByUsers(Yii::app()->user->id, $_POST['idTicket'], false)));
            }
            else
            {
                echo 'false';
            }
            $imap->close();
        }
        else
        {
            echo 'false';
        }
    }
    
    
    /**
     * Método para retornar los datos del ticket que se mostrarán al mandar un correo
     * @param integer $idTicket
     * @return array
     */
    public static function getTicketAsArray($idTicket)
    {
        $data=Ticket::ticketsByUsers(CrugeUser2::getUserTicket($idTicket,true)->iduser,$idTicket,false,false,true);
        $testedNumber=TestedNumber::getTestedNumberArray($idTicket);
        
        $datos = array(
            'ticketNumber'=>$data->ticket_number, 
            'username'=>CrugeUser2::getUserTicket($idTicket),
            'emails'=>Mail::getNameMails($idTicket),
            'failure'=>$data->idFailure->name,
            'originationIp'=>$data->origination_ip,
            'destinationIp'=>$data->destination_ip,
            'prefix'=>$data->prefix,
            'gmt'=>null,
            'testedNumber'=>null,
            'country'=>null,
            'date'=>null,
            'hour'=>null,
            'description'=>'description',
            'cc'=>Mail::getNameMailsCC($idTicket),
            'bcc'=>Mail::getNameMailsBcc($idTicket),
            'speech'=>null,
            'idTicket'=>$idTicket,
            'optionOpen'=>$data->option_open
        );
        
        if ($testedNumber != null) {
            $numbers = array(
                'testedNumber'=>$testedNumber['number'],
                'country'=>$testedNumber['country'],
                'date'=>$testedNumber['date'],
                'hour'=>$testedNumber['hour'],
            );
            
            $datos = array_merge($datos, $numbers);
        }
        
        if (isset($data->idGmt->name)) {
            $gmt = array('gmt' => $data->idGmt->name);
            $datos = array_merge($datos, $gmt);
        }
        
        return $datos;
    }
    
    public function actionTestimap()
    {
        error_reporting(E_ALL & ~E_NOTICE); 
        $imap = new Imap();
        $mails = $imap->runConsole(2);
        $imap->deleteMessage($mails, true);
        $imap->close();
        $this->render('imap', array('mails'=>$mails));
    }
    
    /**
     * Retorna la cantidad de tickets dependiendo del color del mismo
     * @return array
     */
    private function _countColorsTicket()
    {
        $model=new Ticket;
        $white = 0;
        $yellow = 0;
        $red = 0; 
        foreach ($model::ticketsByUsers(Yii::app()->user->id, false) as $ticket) {          
            $timeTicket = Utility::getTime($ticket->date, $ticket->hour);
            // Tickes a partir de las 6:00am
            if ($timeTicket <= 64800)
                $white += 1;
            // Tickets de antes de las 6:00am hasta 6:00am del dia anterior
            elseif ($timeTicket > 64800 && $timeTicket <= 151200) 
                $yellow += 1;
            else 
                $red += 1;
        }
        
        $green = $model::countTicketClosed();
        $totalTickets = $white + $yellow + $green + $red;
        
        return array(
            'white'=>$white,
            'yellow'=>$yellow,
            'green'=>$green,
            'red'=>$red,
            'percentageWhite'=>round(($white/$totalTickets) * 100, 1),
            'percentageYellow'=>round(($yellow/$totalTickets) * 100, 1),
            'percentageGreen'=>round(($green/$totalTickets) * 100, 1),
            'percentageRed'=>round(($red/$totalTickets) * 100, 1),
        );
    }
}