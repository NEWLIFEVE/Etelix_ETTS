<?php

/**
 * This is the model class for table "ticket".
 *
 * The followings are the available columns in table 'ticket':
 * @property integer $id
 * @property integer $id_ticket
 * @property integer $id_failure
 * @property integer $id_status
 * @property string $origination_ip
 * @property string $destination_ip
 * @property string $date
 * @property string $machine_ip
 * @property string $hour
 * @property integer $prefix
 * @property integer $id_gmt
 * @property string $ticket_number
 *
 * The followings are the available model relations:
 * @property TicketRelation[] $ticketRelations
 * @property TicketRelation[] $ticketRelations1
 * @property TestedNumber[] $testedNumbers
 * @property File[] $files
 * @property MailTicket[] $mailTickets
 * @property DescriptionTicket[] $descriptionTickets
 * @property Failure $idFailure
 * @property Status $idStatus
 * @property Ticket $idTicket
 * @property Ticket[] $tickets
 * @property Gmt $idGmt
 */
class Ticket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ticket the static model class
	 */
        public $maximo;
        public $id_manager;
        public $description;
        public $mail = array();
        public $tested_numbers = array();
        public $country = array();
        public $date_number = array();
        public $hour_number = array();
        public $ids;
        
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
                        
			array('id_failure, id_status, origination_ip, destination_ip, date, machine_ip', 'required'),
			array('id_ticket, id_failure, id_status, id_gmt', 'numerical', 'integerOnly'=>true),
			array('origination_ip, destination_ip, machine_ip', 'length', 'max'=>64),
			array('ticket_number', 'length', 'max'=>50),
			array('hour', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_ticket, id_failure, id_status, origination_ip, destination_ip, date, machine_ip, hour, prefix, id_gmt, ticket_number', 'safe', 'on'=>'search'),
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
                        'ticketRelations' => array(self::HAS_MANY, 'TicketRelation', 'id_ticket_father'),
			'ticketRelations1' => array(self::HAS_MANY, 'TicketRelation', 'id_ticket_son'),
			'testedNumbers' => array(self::HAS_MANY, 'TestedNumber', 'id_ticket'),
			'files' => array(self::HAS_MANY, 'File', 'id_ticket'),
			'mailTickets' => array(self::HAS_MANY, 'MailTicket', 'id_ticket'),
//			'descriptionTickets' => array(self::HAS_MANY, 'DescriptionTicket', 'id_ticket'),
                        'descriptionTickets' => array(self::BELONGS_TO, 'DescriptionTicket', 'id'),
			'idFailure' => array(self::BELONGS_TO, 'Failure', 'id_failure'),
			'idStatus' => array(self::BELONGS_TO, 'Status', 'id_status'),
			'idTicket' => array(self::BELONGS_TO, 'Ticket', 'id_ticket'),
			'tickets' => array(self::HAS_MANY, 'Ticket', 'id_ticket'),
			'idGmt' => array(self::BELONGS_TO, 'Gmt', 'id_gmt'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_ticket' => 'Id Ticket',
			'id_failure' => 'Id Failure',
			'id_status' => 'Id Status',
			'origination_ip' => 'Origination Ip',
			'destination_ip' => 'Destination Ip',
			'date' => 'Date',
			'machine_ip' => 'Machine Ip',
			'hour' => 'Hour',
			'prefix' => 'Prefix',
			'id_gmt' => 'Id Gmt',
			'ticket_number' => 'Ticket Number',
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
                
                $tipoUsuario = CrugeAuthassignment::getRoleUser();
                if ($tipoUsuario == "C") 
                    $criteria->condition = "id in(".implode(",", self::getIdTicketsByuser()).")";
                
                $criteria->order = "id DESC";             
                $criteria->compare('id',$this->id);
		$criteria->compare('id_ticket',$this->id_ticket);
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
        
        public static function ticketsByUsers($idUser, $idTicket = false, $returnArray = true)
        {
            
            $tipoUsuario = CrugeAuthassignment::getRoleUser();
            $conditionUser = '';
            $conditionTicket = '';
            
            // Si el tipo de usuario es cliente, se muestran sus tickets, de lo
            // contrario la condicion queda en blanco, es decir, se muestran todos
            // los tickets de todos los usuarios
            if ($tipoUsuario == "C")
                $conditionUser = ' where id_user = ' . $idUser;
            
            // Si no se envía el id de un ticket se muestran todos los tickets,
            // De lo contrario se muestra solo el ticket seleccionado
            if ($idTicket) 
                $conditionTicket = ' and t.id = ' . $idTicket;
            
            // Si $returnArray esta en true, retorna un array con los datos del ticket
            if ($returnArray) {
                return self::model()->findAllBySql(
                                    "select *, t.id as ids 
                                    from 
                                    ticket t, description_ticket dt  
                                    where 
                                    t.id in(select distinct(id_ticket) from mail_ticket where id_mail_user in(select id from mail_user $conditionUser)) and
                                    t.id = dt.id_ticket $conditionTicket
                                    order by t.id desc");
            
            // De lo contrario no retorna un array
            } else {
                return self::model()->findBySql(
                                    "select *, t.id as ids 
                                    from 
                                    ticket t, description_ticket dt  
                                    where 
                                    t.id in(select distinct(id_ticket) from mail_ticket where id_mail_user in(select id from mail_user $conditionUser)) and
                                    t.id = dt.id_ticket $conditionTicket
                                    order by t.id desc");
            }
        }
        
        
        public static function getIdTicketsByuser()
        {
            $ids = array();
            foreach (self::ticketsByUsers(Yii::app()->user->id) as $value) {
                $ids[] = $value->id;
            }
            return $ids;
        }

        public static function ticketsRelations($idTicket, $idUser = false)
        {
            $conditionUser = '';
            if ($idUser)
                $conditionUser = 'where id_user = ' . $idTicket;
            return self::model()->findAllBySql(
                        "select * from ticket where id in(
                        select tr.id_ticket_son
                        from 
                        ticket t, ticket_relation tr
                        where 
                        t.id in(select distinct(id_ticket) from mail_ticket where id_mail_user in(select id from mail_user $conditionUser)) and
                        t.id = tr.id_ticket_father and t.id = $idTicket
                        order by t.id desc
                        )");
        }
        
        
        
}