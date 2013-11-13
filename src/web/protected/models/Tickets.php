<?php

/**
 * This is the model class for table "tickets".
 *
 * The followings are the available columns in table 'tickets':
 * @property integer $id
 * @property integer $tickets_id
 * @property integer $fallas_id
 * @property integer $prioridad_id
 * @property integer $statu_id
 * @property integer $usuarios_id
 * @property string $origen_ip
 * @property string $destino_ip
 * @property integer $prefijo
 * @property string $fecha_ticket
 * @property string $ip_maquina
 * @property integer $estado
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
        public $mail;
        public $descripcion;
        public $tested_numbers = array();
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
			array('tickets_id, fallas_id, prioridad_id, origen_ip, destino_ip, prefijo, mail, descripcion', 'required'),
			array('tickets_id, fallas_id, prioridad_id, prefijo', 'numerical', 'integerOnly'=>true),
                        array('origen_ip, destino_ip', 'application.extensions.ipvalidator.IPValidator', 'version' => 'v4'),
           
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tickets_id, fallas_id, prioridad_id, statu_id, usuarios_id, origen_ip, destino_ip, prefijo, fecha_ticket, ip_maquina, estado', 'safe', 'on'=>'search'),
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
			'usuarios' => array(self::BELONGS_TO, 'Usuarios', 'usuarios_id'),
			'statu' => array(self::BELONGS_TO, 'Statu', 'statu_id'),
			'prioridad' => array(self::BELONGS_TO, 'Prioridad', 'prioridad_id'),
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
			'fallas_id' => 'Fallas',
			'prioridad_id' => 'Prioridad',
			'statu_id' => 'Statu',
			'usuarios_id' => 'Usuarios',
			'origen_ip' => 'Origen Ip',
			'destino_ip' => 'Destino Ip',
			'prefijo' => 'Prefijo',
			'fecha_ticket' => 'Fecha Ticket',
			'ip_maquina' => 'Ip Maquina',
			'estado' => 'Estado',
                        'mail' => 'Response to',
                        'descripcion' => 'Descripcion'
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
		$criteria->compare('prioridad_id',$this->prioridad_id);
		$criteria->compare('statu_id',$this->statu_id);
		$criteria->compare('usuarios_id',$this->usuarios_id);
		$criteria->compare('origen_ip',$this->origen_ip,true);
		$criteria->compare('destino_ip',$this->destino_ip,true);
		$criteria->compare('prefijo',$this->prefijo);
		$criteria->compare('fecha_ticket',$this->fecha_ticket,true);
		$criteria->compare('ip_maquina',$this->ip_maquina,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
