<?php

/**
 * This is the model class for table "archivos".
 *
 * The followings are the available columns in table 'archivos':
 * @property integer $id
 * @property integer $tickets_id
 * @property string $nombre_guardado
 * @property string $nombre_real
 * @property double $tamanio
 *
 * The followings are the available model relations:
 * @property Tickets $tickets
 */
class Archivos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'archivos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tickets_id, nombre_guardado, nombre_real, tamanio', 'required'),
			array('tickets_id', 'numerical', 'integerOnly'=>true),
			array('tamanio', 'numerical'),
			array('nombre_guardado, nombre_real', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tickets_id, nombre_guardado, nombre_real, tamanio', 'safe', 'on'=>'search'),
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
			'nombre_guardado' => 'Nombre Guardado',
			'nombre_real' => 'Nombre Real',
			'tamanio' => 'Tamanio',
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
		$criteria->compare('nombre_guardado',$this->nombre_guardado,true);
		$criteria->compare('nombre_real',$this->nombre_real,true);
		$criteria->compare('tamanio',$this->tamanio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Archivos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
