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
 * @property Contrato[] $contratos
 * @property AccountingDocument[] $accountingDocuments
 * @property AccountingDocumentTemp[] $accountingDocumentTemps
 * @property CarrierManagers[] $carrierManagers
 * @property CarrierGroups $idCarrierGroups
 * @property Balance[] $balances
 * @property Balance[] $balances1
 * @property DestinationSupplier[] $destinationSuppliers
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
			'contratos' => array(self::HAS_MANY, 'Contrato', 'id_carrier'),
			'accountingDocuments' => array(self::HAS_MANY, 'AccountingDocument', 'id_carrier'),
			'accountingDocumentTemps' => array(self::HAS_MANY, 'AccountingDocumentTemp', 'id_carrier'),
			'carrierManagers' => array(self::HAS_MANY, 'CarrierManagers', 'id_carrier'),
			'idCarrierGroups' => array(self::BELONGS_TO, 'CarrierGroups', 'id_carrier_groups'),
			'balances' => array(self::HAS_MANY, 'Balance', 'id_carrier_supplier'),
			'balances1' => array(self::HAS_MANY, 'Balance', 'id_carrier_customer'),
			'destinationSuppliers' => array(self::HAS_MANY, 'DestinationSupplier', 'id_carrier'),
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
        
        
        public static function getListCarrier()
        {
            return self::model()->findAll();
        }
        
}
