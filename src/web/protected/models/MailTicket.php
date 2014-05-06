<?php

/**
 * This is the model class for table "mail_ticket".
 *
 * The followings are the available columns in table 'mail_ticket':
 * @property integer $id_mail_user
 * @property integer $id_ticket
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property MailUser $idMailUser
 * @property Ticket $idTicket
 */
class MailTicket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailTicket the static model class
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
		return 'mail_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_mail_user, id_ticket', 'required'),
			array('id_mail_user, id_ticket', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_mail_user, id_ticket, id', 'safe', 'on'=>'search'),
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
			'idMailUser' => array(self::BELONGS_TO, 'MailUser', 'id_mail_user'),
			'idTicket' => array(self::BELONGS_TO, 'Ticket', 'id_ticket'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_mail_user' => 'Id Mail User',
			'id_ticket' => 'Id Ticket',
			'id' => 'ID',
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

		$criteria->compare('id_mail_user',$this->id_mail_user);
		$criteria->compare('id_ticket',$this->id_ticket);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Retorna los correos que tienen asociado un o varios tickets
         * @param integer $id_tickets
         * @return array|null
         */
        public static function getMails($id_tickets)
        {
            return self::model()->findAll("id_ticket = $id_tickets AND id_type_mailing = 1");
        }
        
        /**
         * Retorna los correos(cc) que tienen asociado un o varios tickets
         * @param integer $id_tickets
         * @return array|null
         */
        public static function getCc($id_tickets)
        {
            $mail =  self::model()->findAll("id_ticket = $id_tickets AND id_type_mailing = 2");
            if ($mail != null)
            {
                return $mail;
            }
            return null;
        }
        
        /**
         * Retorna los correos(bcc) que tienen asociado un o varios tickets
         * @param integer $id_tickets
         * @return array|null
         */
        public static function getBcc($id_tickets)
        {
            $mail = self::model()->findAll("id_ticket = $id_tickets AND id_type_mailing = 3");
            if ($mail != null)
            {
                return $mail;
            }
            return null;
        }
        
        /**
         * Gurada los mails que apliquen a un ticket relacionado
         * 
         * @param array $attributes
         * @param int $typeMail
         * @return boolean
         */
        public static function saveMailTicket($attributes, $typeMail)
        {
            $isOk=true;
            if (is_array($attributes['responseTo']))
            {
                $count=count($attributes['responseTo']);
                for($i=0; $i<$count; $i++)
                {
                    $model=new MailTicket;
                    $model->id_mail_user=$attributes['responseTo'][$i];
                    $model->id_ticket=$attributes['id_ticket'];
                    $model->id_type_mailing=$typeMail;
                    if (!$model->save()) $isOk=false;
                }
            }
            else
            {
                $model=new MailTicket;
                $model->id_mail_user=$attributes['responseTo'];
                $model->id_ticket=$attributes['id_ticket'];
                $model->id_type_mailing=$typeMail;
                if (!$model->save()) $isOk=false;
            }
            return $isOk;
        }
}