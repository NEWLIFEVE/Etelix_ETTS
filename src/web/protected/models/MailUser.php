<?php

/**
 * This is the model class for table "mail_user".
 *
 * The followings are the available columns in table 'mail_user':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_mail
 * @property integer $status
 * @property integer $assign_by
 * 
 * The followings are the available model relations:
 * @property Mail $idMail
 * @property User $idUser
 * @property MailTicket[] $mailTickets
 */
class MailUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailUser the static model class
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
		return 'mail_user';
	}
        
        public $mail;
        public $mailcount;
	
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_mail', 'required'),
			array('id_user, id_mail', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, id_mail', 'safe', 'on'=>'search'),
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
			'idMail' => array(self::BELONGS_TO, 'Mail', 'id_mail'),
			'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
//			'mailTicket' => array(self::HAS_MANY, 'MailTicket', 'id_mail_user'),
			'mailTicket' => array(self::BELONGS_TO, 'MailTicket', 'id_mail_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_mail' => 'Id Mail',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_mail',$this->id_mail);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * 
         * @param int $user
         * @param boolean $json
         * @return array
         */
        public static function getMails($user, $json = false, $etelixAsCarrier = false, $idTicket = false)
        {   
            $assignBy='';
            $implode='';
            if (CrugeAuthassignment::getRoleUser() == 'C') { 
                $assignBy=' AND assign_by = 0';
            } else {
                if ($etelixAsCarrier == 'true') $assignBy=' AND assign_by = 0';
            }
            
            if ($idTicket) $implode = ' and mu.id NOT IN (' . implode(",", self::idMailUser($idTicket)) . ')';

            $sql="SELECT mu.id AS id, m.mail AS mail
                      FROM mail m, mail_user mu
                      WHERE mu.id_user = $user AND mu.id_mail = m.id AND mu.status = 1 $assignBy $implode";
            if ($user!=null) 
            {
                if ($json == false)       
                    return self::model()->findAllBySql($sql);
                else 
                    echo CJSON::encode(Mail::model()->findAllBySql($sql));
            }
        }
        
        /**
         * 
         * @param int $idTicket
         * @return array
         */
        public static function getMailsByTicket($idTicket)
        {
            return self::model()->findAll("id in(select id_mail_user from mail_ticket where id_ticket = $idTicket)");
        }
        
        public static function idMailUser($idTicket)
        {
            $id = array();
            $data=self::getMailsByTicket($idTicket);
            if ($idTicket != null)
            {
                foreach ($data as $value) {
                    $id[]=$value->id;
                }
            }
            return $id;
        }

        
        /**
         * 
         * @param int $user
         * @return boolean
         */
        public static function getCountMail($user)
        {
                $count =self::model()->findBySql("SELECT COUNT(id_user) AS mailcount FROM mail_user WHERE id_user = $user AND status = 1 AND assign_by=0");
                if($count->mailcount < 5){
                    return TRUE;
                }else{
                    return FALSE;
                }
        }
}