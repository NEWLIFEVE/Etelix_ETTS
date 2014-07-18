<?php

/**
 * This is the model class for table "carrier".
 *
 * The followings are the available columns in table 'carrier':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $record_date
 * @property integer $id_carrier_groups
 * @property integer $group_leader
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property DestinationSupplier[] $destinationSuppliers
 * @property Contrato[] $contratos
 * @property Balance[] $balances
 * @property Balance[] $balances1
 * @property AccountingDocument[] $accountingDocuments
 * @property CarrierManagers[] $carrierManagers
 * @property AccountingDocumentTemp[] $accountingDocumentTemps
 * @property CarrierGroups $idCarrierGroups
 * @property BalanceTime[] $balanceTimes
 * @property BalanceTime[] $balanceTimes1
 */
class Carrier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'carrier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, record_date', 'required'),
			array('id_carrier_groups, group_leader, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, record_date, id_carrier_groups, group_leader, status', 'safe', 'on'=>'search'),
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
			'destinationSuppliers' => array(self::HAS_MANY, 'DestinationSupplier', 'id_carrier'),
			'contratos' => array(self::HAS_MANY, 'Contrato', 'id_carrier'),
			'balances' => array(self::HAS_MANY, 'Balance', 'id_carrier_customer'),
			'balances1' => array(self::HAS_MANY, 'Balance', 'id_carrier_supplier'),
			'accountingDocuments' => array(self::HAS_MANY, 'AccountingDocument', 'id_carrier'),
			'carrierManagers' => array(self::HAS_MANY, 'CarrierManagers', 'id_carrier'),
			'accountingDocumentTemps' => array(self::HAS_MANY, 'AccountingDocumentTemp', 'id_carrier'),
			'idCarrierGroups' => array(self::BELONGS_TO, 'CarrierGroups', 'id_carrier_groups'),
			'balanceTimes' => array(self::HAS_MANY, 'BalanceTime', 'id_carrier_customer'),
			'balanceTimes1' => array(self::HAS_MANY, 'BalanceTime', 'id_carrier_supplier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address' => 'Address',
			'record_date' => 'Record Date',
			'id_carrier_groups' => 'Id Carrier Groups',
			'group_leader' => 'Group Leader',
			'status' => 'Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('record_date',$this->record_date,true);
		$criteria->compare('id_carrier_groups',$this->id_carrier_groups);
		$criteria->compare('group_leader',$this->group_leader);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->soriDB;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Carrier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     *
     */
    public static function getListUserCarriers()
    {
        $idCarriers=array();
        foreach (CrugeUser2::getUsuerByIdCarrier() as $carrier)
        {
            $idCarriers[]=$carrier->id_carrier;
        }
        return $idCarriers;
    }
    
    /**
     *
     */
    public static function getCarriers($returnNameCarrier = false, $idTicket = false)
    {
        if($returnNameCarrier)
        {
            $idCarrier=CrugeUser2::getUserTicket($idTicket,true,true)->id_carrier;
            $idUser=CrugeUser2::getUserTicket($idTicket,true)->iduser;
            
            if($idCarrier!=null)
            {
                $carrier =  self::model()->find("id = $idCarrier");
                if ($carrier!=null) return $carrier->name;
                else return '';
            }
            else
            {
                return 'ETELIX('.CrugeAuthassignment::getRoleUser(true, $idUser) . ')';
            }
        }
        else
        {
            return CHtml::listData(self::model()->findAll("id NOT IN(".implode(",", self::getListUserCarriers()).") ORDER BY name ASC"), 'id', 'name');
        }
        
    }
       
    /**
     * Método que retorna los id de los carriers dependiendo si es cliente o
     * proveedor. Se esta llamando la vista carrier_proveedor o carrier_cliente
     * dependiendo el caso.
     * 
     * @param string $type
     * @return int
     */
    public static function getCarriersByClass($type)
    {
        $id=array();
        $consulta=null;
        
        if($type=='supplier') 
        {
            $consulta=self::getSupplier();
            foreach($consulta as $value)
            {
                $id[]=$value->id;
            }
        }
        else if($type=='customer')
        {
            $consulta=self::getCustomer();
            foreach($consulta as $value)
            {
                $id[]=$value->id;
            }
        }
        else
        {
            $id=null;
        }
        return $id;
    }

    /**
     * @access public
     * @static
     */   
    public static function getCustomer($id = false)
    {
        if($id)
        {
            return self::model()->findAllBySql("SELECT car.*
                                                FROM carrier car, contrato con, contrato_termino_pago ctp
                                                WHERE con.id_carrier=car.id AND con.sign_date<=current_date AND con.end_date IS NULL AND ctp.id_contrato=con.id AND car.id={$id} AND ctp.start_date<=current_date AND ctp.end_date IS NULL AND ctp.id_termino_pago<>(SELECT id FROM termino_pago WHERE name='Sin estatus')
                                                ORDER BY car.name ASC");
        }
        else
        {
            return self::model()->findAllBySql("SELECT car.id
                                                FROM carrier car, contrato con, contrato_termino_pago ctp
                                                WHERE con.id_carrier=car.id AND con.sign_date<=current_date AND con.end_date IS NULL AND ctp.id_contrato=con.id AND ctp.start_date<=current_date AND ctp.end_date IS NULL AND ctp.id_termino_pago<>(SELECT id FROM termino_pago WHERE name='Sin estatus')
                                                ORDER BY car.name ASC");
        }
    }

    /**
     * @access public
     * @static
     */
    public static function getSupplier($id = false)
    {
        if($id)
        {
            return self::model()->findAllBySql("SELECT car.*
                                                FROM carrier car, contrato con, contrato_termino_pago_supplier ctps
                                                WHERE con.id_carrier=car.id AND con.sign_date<=current_date AND con.end_date IS NULL AND ctps.id_contrato=con.id AND car.id={$id} AND ctps.start_date<=current_date AND ctps.end_date IS NULL AND ctps.id_termino_pago_supplier<>(SELECT id FROM termino_pago WHERE name='Sin estatus')
                                                ORDER BY car.name ASC");
        }
        else
        {
            return self::model()->findAllBySql("SELECT car.id
                                                FROM carrier car, contrato con, contrato_termino_pago_supplier ctps
                                                WHERE con.id_carrier=car.id AND con.sign_date<=current_date AND con.end_date IS NULL AND ctps.id_contrato=con.id AND ctps.start_date<=current_date AND ctps.end_date IS NULL AND ctps.id_termino_pago_supplier<>(SELECT id FROM termino_pago WHERE name='Sin estatus')
                                                ORDER BY car.name ASC");
        }
    }

    /**
     * @access public
     * @static
     */
    public static function getTypeCarrier($idUser)
    {
        $idCarrier=CrugeUser2::getIdCarrier($idUser);
        if($idCarrier != null) 
        {
            if (self::getCustomer($idCarrier) != null && self::getSupplier($idCarrier) != null) 
            {
                return 'CS'; // Customer/Supplier
            }
            if (self::getCustomer($idCarrier) != null && self::getSupplier($idCarrier) == null)
            {
                return 'C'; // Customer
            }
            else
            {
                return 'S'; // Supplier
            }
            
//            if(self::getCustomer($idCarrier) != null) 
//            {
//                return 'Customer';
//            }
//            else
//            {
//                return 'Supplier';
//            }
        }
        return false;
    }

    /**
     * Retorna el nombre de los carriers colocando el id del usuario de etts,
     * si el usuario no tiene carrier retorna un booleano false
     * @access public
     * @static
     * @param int $idUser
     * @return boolean o string
     */   
    public static function getNameByUser($idUser)
    {
        $idCarrier=CrugeUser2::model()->findByPk($idUser)->id_carrier;
        if($idCarrier!=null)
        {
            return self::model()->findByPk($idCarrier)->name;
        }
        else
        {
            return false;
        }
    }
}
