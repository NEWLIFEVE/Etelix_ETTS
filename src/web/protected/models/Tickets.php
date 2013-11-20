<?php

/**
 * This is the model class for table "tickets".
 *
 * The followings are the available columns in table 'tickets':
 * @property integer $id
 * @property integer $tickets_id
 * @property integer $fallas_id
 * @property integer $statu_id
 * @property string $origen_ip
 * @property string $destino_ip
 * @property integer $prefijo
 * @property string $fecha_ticket
 * @property string $ip_maquina
 *
 * The followings are the available model relations:
 * @property Archivos[] $archivoses
 * @property DescripcionTicket[] $descripcionTickets
 * @property Respuestas[] $respuestases
 * @property Usuarios $usuarios
 * @property Statu $statu
 * @property Prioridad $prioridad
 * @property Fallas $fallas
 * @property Tickets $tickets
 * @property Tickets[] $tickets1
 * @property TestedNumbers[] $testedNumbers
 */
class Tickets extends CActiveRecord
{ 
        public $descripcion;
        public $mail = array();
        public $tested_numbers = array();
        public $destination = array();
        public $fecha = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tickets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail, tested_numbers, destination, fecha,  fallas_id, origen_ip, destino_ip, prefijo,  descripcion', 'required'),
			array('tickets_id, fallas_id, prefijo', 'numerical', 'integerOnly'=>true),
                        array('origen_ip, destino_ip', 'application.extensions.ipvalidator.IPValidator', 'version' => 'v4'),
           
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tickets_id, fallas_id, statu_id, origen_ip, destino_ip, prefijo, fecha_ticket, ip_maquina', 'safe', 'on'=>'search'),
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
			'archivoses' => array(self::HAS_MANY, 'Archivos', 'tickets_id'),
			'descripcionTickets' => array(self::HAS_MANY, 'DescripcionTicket', 'tickets_id'),
			'respuestases' => array(self::HAS_MANY, 'Respuestas', 'tickets_id'),
                    
                        // Prueba de ralacion Many_Many
                        'mail' => array(self::MANY_MANY, 'Usuarios', 'mail_tickets(mail_id,tickets_id)'),
                    
                    
                    
//			'mail' => array(self::BELONGS_TO, 'Mail', 'mail_id'),
			'status' => array(self::BELONGS_TO, 'Status', 'statu_id'),
			'fallas' => array(self::BELONGS_TO, 'Fallas', 'fallas_id'),
			'tickets' => array(self::BELONGS_TO, 'Tickets', 'tickets_id'),
			'tickets1' => array(self::HAS_MANY, 'Tickets', 'tickets_id'),
			'testedNumbers' => array(self::HAS_MANY, 'TestedNumbers', 'tickets_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tickets_id' => 'Tickets',
<<<<<<< HEAD
			'fallas_id' => 'Failure',
			'statu_id' => 'Status',
			'origen_ip' => 'Origination Ip',
			'destino_ip' => 'Destination Ip',
			'prefijo' => 'Prefix',
=======
			'fallas_id' => 'Fallas',
			'statu_id' => 'Statu',
			'origen_ip' => 'Origination IP (Customer IP)',
			'destino_ip' => 'DestinationIP IP (Etelix IP)',
			'prefijo' => 'Prefijo',
>>>>>>> 3a9ad685f63a762fcee91b9b6f26eb79b4357486
			'fecha_ticket' => 'Fecha Ticket',
			'ip_maquina' => 'Ip Maquina',
                        'mail' => 'Response to',
                        'descripcion' => 'Description',
                        'destination' => 'Destinations'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tickets_id',$this->tickets_id);
		$criteria->compare('fallas_id',$this->fallas_id);
		$criteria->compare('statu_id',$this->statu_id);
		$criteria->compare('origen_ip',$this->origen_ip,true);
		$criteria->compare('destino_ip',$this->destino_ip,true);
		$criteria->compare('prefijo',$this->prefijo);
		$criteria->compare('fecha_ticket',$this->fecha_ticket,true);
		$criteria->compare('ip_maquina',$this->ip_maquina,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function addTestedNumbers($tickets_id, $destinos_id, $numero, $fecha_tested_numbers)
	{
		$sql = "INSERT INTO tested_numbers(tickets_id, destinos_id, numero, fecha_tested_numbers) " .
		       "VALUES (:tickets_id, :destinos_id, :numero, :fecha_tested_numbers)";
		$comando = Yii::app()->db->createCommand($sql);
		$comando->bindParam(":tickets_id", $tickets_id, PDO::PARAM_INT);
		$comando->bindParam(":destinos_id", $destinos_id, PDO::PARAM_INT);
		$comando->bindParam(":numero", $numero, PDO::PARAM_INT);
                $comando->bindParam(":fecha_tested_numbers", $fecha_tested_numbers, PDO::PARAM_STR);
		$control = $comando->execute();
		return ($control > 0);
	}
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tickets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
