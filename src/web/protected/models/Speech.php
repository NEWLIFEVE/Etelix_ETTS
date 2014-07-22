<?php


/**
 * This is the model class for table "speech".
 *
 * The followings are the available columns in table 'speech':
 * @property integer $id
 * @property string $speech
 * @property string $code
 * @property string $title
 * @property integer $id_language
 *
 * The followings are the available model relations:
 * @property Language $idLanguage
 * @property DescriptionTicket[] $descriptionTickets
 * @property FailureSpeech[] $failureSpeeches
 */
class Speech extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'speech';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('speech', 'required'),
			array('id_language', 'numerical', 'integerOnly'=>true),
			array('code, title', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, speech, code, title, id_language', 'safe', 'on'=>'search'),
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
			'idLanguage' => array(self::BELONGS_TO, 'Language', 'id_language'),
			'descriptionTickets' => array(self::HAS_MANY, 'DescriptionTicket', 'id_speech'),
                        'failureSpeeches' => array(self::HAS_MANY, 'FailureSpeech', 'id_speech'),
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'speech' => 'Speech',
			'code' => 'Code',
			'title' => 'Title',
			'id_language' => 'Id Language',
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
		$criteria->compare('speech',$this->speech,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('id_language',$this->id_language);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Speech2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Método para retornar una lista de los speech en ingles dependiendo del tipo de carrier
         * @param string $ticketNumber El número del ticket 
         * @return array
         */
        public static function getSpeech($ticketNumber = false)
        {
            if ($ticketNumber)
            {
                if (Utility::formatTicketNumber($ticketNumber) == 'Customer')
                    return self::model()->findAllBySql("SELECT * FROM speech WHERE code LIKE 'C%' AND id_language = 1 ORDER BY id ASC");
                else
                    return self::model()->findAllBySql("SELECT * FROM speech WHERE code LIKE 'S%' AND id_language = 1 ORDER BY id ASC");
            }
            else
            {
                return self::model()->findAll(array('order' => 'id ASC'));
            }
        }
        
        /**
         * Método para retornar una lista de los speech en español dependiendo del tipo de carrier
         * @param string $ticketNumber El número del ticket 
         * @return array
         */
        public static function getSpeechSpanish($ticketNumber = false)
        {
            if ($ticketNumber)
            {
                if (Utility::formatTicketNumber($ticketNumber) == 'Customer')
                    return self::model()->findAllBySql("SELECT * FROM speech WHERE code LIKE 'C%' AND id_language = 2 ORDER BY id ASC");
                else
                    return self::model()->findAllBySql("SELECT * FROM speech WHERE code LIKE 'S%' AND id_language = 2 ORDER BY id ASC");
            }
            else
            {
                return self::model()->findAll(array('order' => 'id ASC'));
            }
        }
        
}
