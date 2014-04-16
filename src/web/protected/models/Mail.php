<?php

/**
 * This is the model class for table "mail".
 *
 * The followings are the available columns in table 'mail':
 * @property integer $id
 * @property string $mail
 *
 * The followings are the available model relations:
 * @property MailUser[] $mailUsers
 */
class Mail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mail the static model class
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
		return 'mail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mail', 'required'),
			array('mail', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mail', 'safe', 'on'=>'search'),
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
			'mailUsers' => array(self::HAS_MANY, 'MailUser', 'id_mail'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mail' => 'Mail',
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
		$criteria->compare('mail',$this->mail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Método para retornal los emails
         * @param string $condition
         * @return array
         */
        public static function getMails($condition = false)
        {
            if (!$condition)
                return self::model()->findAll();
            else
                return self::model()->findAll($condition);
        }

        /**
         * Método para buscar los nombres de los correos filtrado por id_ticket
         * @param integer $id_ticket
         * @return array
         */
        public static function getNameMails($id_ticket)
        {
            $mailID = array();
            $correo = array();
            
            foreach (MailTicket::getMails($id_ticket) as $value)
                $mailID[] = $value->idMailUser->id_mail;
            
            foreach (self::getMails("id in(".implode(",", $mailID).")") as $value)
                $correo[] = $value->mail;
            
            return $correo;
        }
        
        /**
         * Método para buscar los nombres de los correos(cc) filtrado por id_ticket
         * @param integer $id_ticket
         * @return array
         */
        public static function getNameMailsCC($id_ticket)
        {
            $mailID = null;
            $correo = null;
            $cc=MailTicket::getCc($id_ticket);
            
            if ($cc != null) {
                foreach ($cc as $value)
                    $mailID[] = $value->idMailUser->id_mail;
            }
            if ($mailID != null) {
                foreach (self::getMails("id in(".implode(",", $mailID).")") as $value)
                    $correo[] = $value->mail;
            }
            
            return $correo;
        }
        
        /**
         * Método para buscar los nombres de los correos(bcc) filtrado por id_ticket
         * @param integer $id_ticket
         * @return array
         */
        public static function getNameMailsBcc($id_ticket)
        {
            $mailID = null;
            $correo = null;
            $bcc=MailTicket::getBcc($id_ticket);
            
            if ($bcc != null) {
                foreach ($bcc as $value)
                    $mailID[] = $value->idMailUser->id_mail;
            }
            if ($mailID != null) {
                foreach (self::getMails("id in(".implode(",", $mailID).")") as $value)
                    $correo[] = $value->mail;
            }
            
            return $correo;
        }
        
        /**
         * Método para mostrar los mails asociados a un ticket
         * @param int $idTicket
         * @return array
         */
        public static function getMailsTicket($idTicket)
        {
            return self::model()->findAllBySql("SELECT mt.id, m.mail FROM 
                                          mail_ticket mt, mail_user mu, mail m
                                          WHERE 
                                          mt.id_ticket = $idTicket AND 
                                          mt.id_type_mailing = 1 AND
                                          mt.id_mail_user = mu.id AND
                                          mu.id_mail = m.id");
        }
        
}