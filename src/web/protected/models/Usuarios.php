<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property integer $rol_id
 * @property string $nombres
 * @property string $login
 * @property string $pass
 * @property integer $estatus
 *
 * The followings are the available model relations:
 * @property Rol $rol
 * @property Mail[] $mails
 * @property Tickets[] $tickets
 */
class Usuarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol_id, nombres, login, pass, estatus', 'required'),
			array('rol_id, estatus', 'numerical', 'integerOnly'=>true),
			array('nombres', 'length', 'max'=>100),
			array('login', 'length', 'max'=>40),
			array('pass', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, rol_id, nombres, login, pass, estatus', 'safe', 'on'=>'search'),
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
			'rol' => array(self::BELONGS_TO, 'Rol', 'rol_id'),
			'mails' => array(self::HAS_MANY, 'Mail', 'usuarios_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rol_id' => 'Rol',
			'nombres' => 'Nombres',
			'login' => 'Login',
			'pass' => 'Pass',
			'estatus' => 'Estatus',
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
		$criteria->compare('rol_id',$this->rol_id);
		$criteria->compare('nombres',$this->nombres,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('estatus',$this->estatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
