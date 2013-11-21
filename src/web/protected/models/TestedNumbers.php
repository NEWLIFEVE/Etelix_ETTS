<?php

/**
 * This is the model class for table "tested_numbers".
 *
 * The followings are the available columns in table 'tested_numbers':
 * @property integer $id
 * @property integer $tickets_id
 * @property integer $destinos_id
 * @property integer $numero
 * @property string $date_numbers
 * @property string $hour_numbers
 * 
 * The followings are the available model relations:
 * @property Destinos $destinos
 * @property Tickets $tickets
 */
class TestedNumbers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tested_numbers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tickets_id, destinos_id, numero', 'required'),
			array('tickets_id, destinos_id, numero', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tickets_id, destinos_id, numero', 'safe', 'on'=>'search'),
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
			'destinos' => array(self::BELONGS_TO, 'Destinos', 'destinos_id'),
			'tickets' => array(self::BELONGS_TO, 'Tickets', 'tickets_id'),
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
			'destinos_id' => 'Destinos',
			'numero' => 'Numero',
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
		$criteria->compare('destinos_id',$this->destinos_id);
		$criteria->compare('numero',$this->numero);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestedNumbers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
