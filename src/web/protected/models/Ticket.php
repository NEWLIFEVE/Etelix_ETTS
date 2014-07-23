<?php

/**
 * This is the model class for table "ticket".
 *
 * The followings are the available columns in table 'ticket':
 * @property integer $id
 * @property integer $id_failure
 * @property integer $id_status
 * @property string $origination_ip
 * @property string $destination_ip
 * @property string $date
 * @property string $machine_ip
 * @property string $hour
 * @property integer $id_gmt
 * @property string $ticket_number
 * @property string $prefix
 * @property integer $id_user
 * @property string $option_open
 * @property string $close_ticket
 * @property string $escalated_date
 *
 * The followings are the available model relations:
 * @property MailTicket[] $mailTicket
 * @property TicketRelation[] $ticketRelations
 * @property TicketRelation[] $ticketRelations1
 * @property TestedNumber[] $testedNumbers
 * @property File[] $files
 * @property DescriptionTicket[] $descriptionTickets
 * @property Failure $idFailure
 * @property Gmt $idGmt
 * @property Status $idStatus
 */
class Ticket extends CActiveRecord
{
	/**
         * Máximo será el límite de correos que puedan ser agregados en la interfaz de crear ticket
         * @var int 
         */
        public $maximo;
        
        /**
         * El id del account manager
         * @var int 
         */
        public $id_manager;
        
        /**
         * Descripción del ticket
         * @var string 
         */
        public $description;
        
        /**
         * Mails asociados al usuario al abrir un ticket
         * @var array
         */
        public $mail=array();
        
        /**
         * Los tested numbers
         * @var array 
         */
        public $tested_numbers=array();
        
        /**
         * Los países del tested number
         * @var array 
         */
        public $country=array();
        
        /**
         * La fecha de tested number
         * @var array
         */
        public $date_number=array();
        
        /**
         * La hora de tested number
         * @var array 
         */
        public $hour_number=array();
        
        /**
         * Número que se usará para dar formato al $ticket_number, el cual quedará de la siguiente forma:
         * Ymd-$number_of_the_day-C/S$id_failure
         * 
         * [Ymd] Es el año, mes y día
         * [$number_of_the_day] El conteo de los id's del ticket del día actual
         * [C/S] Si se abrió como customer o como supplier
         * [$id_failure] El id de la falla
         * @var int
         */
        public $number_of_the_day;
        
        /**
         * Tiempo de vida del ticket
         * @var string
         */
        public $lifetime;
        
        /**
         * Color del ticket, el cual depende del tiempo de vida
         * @var string
         */
        public $color;
        
        /**
         * Si el número de ticket es como customer o como supplier
         * @var string
         */
        public $carrier;
        
        /**
         * id del usuario que abrió el ticket
         * @var int 
         */
        public $user_open_ticket;

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ticket the static model class
	 */        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket';
	}     

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('id_failure, id_status, date, machine_ip', 'required'),
                    array('id_failure, id_status, id_gmt', 'numerical', 'integerOnly'=>true),
                    array('origination_ip, destination_ip, machine_ip', 'length', 'max'=>64),
                    array('ticket_number', 'length', 'max'=>50),
                    array('hour, close_ticket, escalated_date', 'safe'),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('id, id_failure, id_status, origination_ip, destination_ip, date, machine_ip, hour, prefix, id_gmt, ticket_number', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'mailTicket' => array(self::HAS_MANY, 'MailTicket', 'id_ticket'),
                    'ticketRelations' => array(self::HAS_MANY, 'TicketRelation', 'id_ticket_father'),
                    'ticketRelations1' => array(self::HAS_MANY, 'TicketRelation', 'id_ticket_son'),
                    'testedNumbers' => array(self::HAS_MANY, 'TestedNumber', 'id_ticket'),
                    'files' => array(self::HAS_MANY, 'File', 'id_ticket'),
                    'descriptionTickets' => array(self::HAS_MANY, 'DescriptionTicket', 'id_ticket'),
                    'idFailure' => array(self::BELONGS_TO, 'Failure', 'id_failure'),
                    'idGmt' => array(self::BELONGS_TO, 'Gmt', 'id_gmt'),
                    'idStatus' => array(self::BELONGS_TO, 'Status', 'id_status'),
                    'idUser'=>array(self::BELONGS_TO, 'CrugeUser2', 'id_user'),
                );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'id'=>'ID',
                    'id_failure'=>'Id Failure',
                    'id_status'=>'Id Status',
                    'origination_ip'=>'Origination Ip',
                    'destination_ip'=>'Destination Ip',
                    'date'=>'Date',
                    'machine_ip'=>'Machine Ip',
                    'hour'=>'Hour',
                    'prefix'=>'Prefix',
                    'id_gmt'=>'Id Gmt',
                    'ticket_number'=>'Ticket Number',
                );
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $tipoUsuario=CrugeAuthassignment::getRoleUser();
                if($tipoUsuario=="C")
                $criteria->condition="id in(".implode(",", self::getIdTicketsByuser()).")";
        
                $criteria->order="id DESC";             
                $criteria->compare('id',$this->id);
		$criteria->compare('id_failure',$this->id_failure);
		$criteria->compare('id_status',$this->id_status);
		$criteria->compare('origination_ip',$this->origination_ip,true);
		$criteria->compare('destination_ip',$this->destination_ip,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('machine_ip',$this->machine_ip,true);
		$criteria->compare('hour',$this->hour,true);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('id_gmt',$this->id_gmt);
		$criteria->compare('ticket_number',$this->ticket_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
        /**
         * Retorna todos los tickets creados
         * @param int $idUser El id del usuairo
         * @param int $idTicket El id del ticket
         * @param bolean $returnArray Si es true, retorna una búsqueda global, de lo contrario busca con un limit 1
         * @param bolean $allTickets Si es true, retorna todos los tickets (abiertos, cerrados y escalados) de lo contrario retorna solo los abiertos y escalados
         * @param bolean $sendMail Si es true es para mandarse por correo
         * @return array
         */
        public static function ticketsByUsers($idUser,$idTicket=false,$returnArray=true,$allTickets=false,$sendMail=false)
        {
            $tipoUsuario=CrugeAuthassignment::getRoleUser();
            $conditionUser='';
            $conditionTicket='';
            $order='ASC';
            $sql='';
            $onlyOpen="id_status IN(SELECT id FROM status WHERE name = 'open' OR name = 'escalated') AND";
            if ($sendMail) $onlyOpen='';

            /**
             * Si el tipo de usuario es cliente, se muestran sus tickets, de lo
             * contrario la condicion queda en blanco, es decir, se muestran todos
             * los tickets de todos los usuarios
             */
            if($tipoUsuario=="C") 
            {
                $conditionUser=' where id_user='.$idUser;
                $order='ASC';
            }

            /**
             * Si no se envía el id de un ticket se muestran todos los tickets,
             * De lo contrario se muestra solo el ticket seleccionado
             */
            if($idTicket) $conditionTicket='AND id='.$idTicket;

            if($allTickets)
            {

                $sql="SELECT *
                      FROM ticket
                      WHERE id IN (SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user $conditionUser)) $conditionTicket
                      ORDER BY id_status, date, hour ASC";


                // Si $returnArray esta en true, retorna un array con los datos del ticket
                if($returnArray)
                {
                    return self::model()->findAllBySql($sql);
                // De lo contrario no retorna un array
                }
                else
                {
                    return self::model()->findBySql($sql);
                }
            }
            else
            {
                $sql="SELECT t.*, t.id AS id
                      FROM (SELECT * 
                            FROM ticket 
                            WHERE $onlyOpen id IN (SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user $conditionUser)) $conditionTicket
                            ) t
                      ORDER BY id_status, date, hour ASC";

                // Si $returnArray esta en true, retorna un array con los datos del ticket
                if($returnArray)
                {
                    return self::model()->findAllBySql($sql);
                // De lo contrario no retorna un array
                }
                else
                {
                    return self::model()->findBySql($sql);
                }
            }
        }

        /**
         * Retorna todos los tickets cerrados
         * @access public
         * @static
         */
        public static function ticketsClosed()
        {
            $conditionUser='';
            if(CrugeAuthassignment::getRoleUser()=="C") $conditionUser=' WHERE id_user='.Yii::app()->user->id;

            return self::model()->findAllBySql("SELECT *, (close_ticket::timestamp - (to_char(date, 'YYYY-MM-DD') || ' ' || to_char(hour, 'HH24:MI:SS'))::timestamp) AS lifetime
                                                FROM ticket
                                                WHERE id IN (SELECT DISTINCT(id_ticket) FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user $conditionUser)) AND 
                                                id_status=2 AND 
                                                close_ticket >= NOW()-'2 week'::interval
                                                ORDER BY id_status, id  ASC");
        }

        /**
         * Retorna el conteo de los tickets cerrados, si el ususario logueado es cliente, solo se contarán sus tickets
         * @return int
         */
        public static function countTicketClosed()
        {
            $conditionUser='';
            if (CrugeAuthassignment::getRoleUser() == "C") {
                $conditionUser = ' WHERE id_user=' . Yii::app()->user->id;
            }
            return self::model()->count(
                    "id IN(SELECT DISTINCT(id_ticket) "
                    . "FROM mail_ticket WHERE id_mail_user IN (SELECT id FROM mail_user $conditionUser)) AND "
                    . "id_status = 2 AND "
                    . "close_ticket >= NOW()-'2 week'::interval"
                    );
        }

        /**
         * Retorna un array de los id's del los tickets. 
         * @return array
         */
        public static function getIdTicketsByuser()
        {
            $ids=array();
            foreach(self::ticketsByUsers(Yii::app()->user->id) as $value)
            {
                $ids[]=$value->id;
            }
            return $ids;
        }

        /**
         * Retorna los tickets relacionados a un ticket padre y a un usuario
         * @param int $idTicket El id del ticekt
         * @param int $idUser El id del usuario
         * @return array
         */
        public static function ticketsRelations($idTicket,$idUser=false)
        {
            $conditionUser='';
            if($idUser) $conditionUser='where id_user='.$idTicket;
            return self::model()->findAllBySql("SELECT * 
                                                FROM ticket 
                                                WHERE id IN (SELECT tr.id_ticket_son
                                                             FROM ticket t, ticket_relation tr
                                                             WHERE t.id IN (SELECT DISTINCT(id_ticket) 
                                                                            FROM mail_ticket 
                                                                            WHERE id_mail_user IN (SELECT id 
                                                                                                   FROM mail_user $conditionUser)) AND t.id=tr.id_ticket_father AND t.id=$idTicket
                                                ORDER BY t.id DESC)");
        }

        /**
         * Retorna el tipo de usuario que esxcribió el primer comentario
         * @param string $ticket_number El número del ticket
         * @return array
         */
        public static function getFirstUser($ticket_number)
        {
            $id=self::model()->find('ticket_number=:number',array(':number'=>$ticket_number))->id;
            $user=DescriptionTicket::model()->find('id_ticket=:id ORDER BY date ASC, hour ASC',array(':id'=>$id))->id_user;
            return $user;
        }

        /**
         * Retorna el id del ticket segun el ticket_number
         * @param string $ticketNumber El número del ticket
         * @return int
         */
        public static function getId($ticketNumber)
        {
            $id=self::model()->find('ticket_number=:number',array(':number'=>$ticketNumber))->id;
            if ($id != null) {
                return $id;
            }
            return null;
        }

        /**
         * Retorna el id del usuario filtrado por id_ticket
         * @param integer $idTicket El id del ticket
         * @return integer
         */
        public static function getIdUser($idTicket)
        {
            return self::model()->findByPk($idTicket)->id_user;
        }

        /**
         * Retorna como fue abierto el ticket, es decir, si el carrier abrió un ticket
         * a etelix, si etelix abrió un ticket como el carrier o si etelix le abre un
         * ticket al carrier
         * 
         * @param integer $idTicket El id del ticket
         * @return string
         */
        public static function getOptionOpen($idTicket)
        {
            return self::model()->findByPk($idTicket)->option_open;
        }

        /**
         * Método para retornar los datos del ticket que se mostrarán al mandar un correo
         * @param integer $idTicket El id del ticket
         * @return array
         */
        public static function getTicketAsArray($idTicket)
        {
            $data=self::ticketsByUsers(CrugeUser2::getUserTicket($idTicket,true)->iduser,$idTicket,false,false,true);
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
       
}
