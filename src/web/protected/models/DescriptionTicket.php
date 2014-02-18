<?php

/**
 * This is the model class for table "description_ticket".
 *
 * The followings are the available columns in table 'description_ticket':
 * @property integer $id
 * @property integer $id_ticket
 * @property string $description
 * @property string $date
 * @property string $hour
 * @property integer $id_speech
 * @property integer $id_user
 * @property integer $read
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property CrugeUser $idUser
 * @property Speech $idSpeech
 * @property Ticket $idTicket
 */
class DescriptionTicket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DescriptionTicket the static model class
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
		return 'description_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket, description, date', 'required'),
			array('id_ticket, id_speech, id_user, read','numerical', 'integerOnly'=>true),
			array('hour', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_ticket, description, date, hour, id_speech, id_user', 'safe', 'on'=>'search'),
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
                        'files' => array(self::HAS_MANY, 'File', 'id_description_ticket'),
			'idTicket' => array(self::BELONGS_TO, 'Ticket', 'id_ticket'),
			'idSpeech' => array(self::BELONGS_TO, 'Speech', 'id_speech'),
			'idUser' => array(self::BELONGS_TO, 'CrugeUser2', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_ticket' => 'Id Ticket',
			'description' => 'Description',
			'date' => 'Date',
			'hour' => 'Hour',
			'id_speech' => 'Id Speech',
            'id_user' => 'Id User',
            'read' => 'Read',
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
		$criteria->compare('id_ticket',$this->id_ticket);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hour',$this->hour,true);
		$criteria->compare('id_speech',$this->id_speech);
        $criteria->compare('id_user',$this->id_user);
        $criteria->compare('read',$this->read);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    /**
     * 
     * @param int $idTicket
     */
    public static function getDescription($idTicket)
    {
        return self::model()->findAllBySql("SELECT * FROM description_ticket WHERE id_ticket=$idTicket ORDER BY id ASC");
    }
}