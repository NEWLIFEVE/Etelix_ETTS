<?php

/**
 * This is the model class for table "cruge_user".
 *
 * The followings are the available columns in table 'cruge_user':
 * @property integer $iduser
 * @property string $regdate
 * @property string $actdate
 * @property string $logondate
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authkey
 * @property integer $state
 * @property integer $totalsessioncounter
 * @property integer $currentsessioncounter
 * @property integer $id_carrier
 *
 * The followings are the available model relations:
 * @property MailUser[] $mailUsers
 * @property CrugeFieldvalue[] $crugeFieldvalues
 * @property CrugeAuthitem[] $crugeAuthitems
 */
class CrugeUser2 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cruge_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state, totalsessioncounter, currentsessioncounter, id_carrier', 'numerical', 'integerOnly'=>true),
			array('username, password', 'length', 'max'=>64),
			array('email', 'length', 'max'=>45),
			array('authkey', 'length', 'max'=>100),
			array('regdate, actdate, logondate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iduser, regdate, actdate, logondate, username, email, password, authkey, state, totalsessioncounter, currentsessioncounter, id_carrier', 'safe', 'on'=>'search'),
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
			'mailUsers' => array(self::HAS_MANY, 'MailUser', 'id_user'),
			'crugeFieldvalues' => array(self::HAS_MANY, 'CrugeFieldvalue', 'iduser'),
			'crugeAuthitems' => array(self::MANY_MANY, 'CrugeAuthitem', 'cruge_authassignment(userid, itemname)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iduser' => 'Iduser',
			'regdate' => 'Regdate',
			'actdate' => 'Actdate',
			'logondate' => 'Logondate',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'authkey' => 'Authkey',
			'state' => 'State',
			'totalsessioncounter' => 'Totalsessioncounter',
			'currentsessioncounter' => 'Currentsessioncounter',
			'id_carrier' => 'Id Carrier',
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

		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('regdate',$this->regdate,true);
		$criteria->compare('actdate',$this->actdate,true);
		$criteria->compare('logondate',$this->logondate,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('authkey',$this->authkey,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('totalsessioncounter',$this->totalsessioncounter);
		$criteria->compare('currentsessioncounter',$this->currentsessioncounter);
		$criteria->compare('id_carrier',$this->id_carrier);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrugeUser2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     
    /**
     *
     */  
    public static function getUsuerByIdCarrier()
    {
        return self::model()->findAll("id_carrier is not null");
    }
    
    /**
     *
     */ 
    public static function getUserTicket($id_ticket, $returnAllNoArray = false, $distinct = false)
    {
        if($returnAllNoArray)
        {
            if($distinct)
            {
                $distinct='distinct(u.*)';
            }
            else
            {
                $distinct='u.*';
            }
            return self::model()->findBySql("SELECT $distinct
            								 FROM ticket t, mail_ticket mt, mail_user mu, cruge_user u
            								 WHERE t.id=mt.id_ticket AND mt.id_mail_user=mu.id AND mu.id_user=u.iduser AND t.id=$id_ticket");
        }
        else
        {
        	return self::model()->findBySql("SELECT distinct(u.username) AS username
        									 FROM ticket t, mail_ticket mt, mail_user mu, cruge_user u
        									 WHERE t.id=mt.id_ticket AND mt.id_mail_user=mu.id AND mu.id_user=u.iduser AND t.id=$id_ticket")->username;
        }
    } 
}
