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
 * @property integer $read_carrier
 * @property integer $read_internal
 * @property integer $response_by
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
			array('id_ticket, id_speech, id_user','numerical', 'integerOnly'=>true),
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
                        'id_user' => 'Id User'
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
        if (empty($idTicket) || !isset($idTicket)) return null;
    
        $query = self::model()->findAllBySql("SELECT * FROM description_ticket WHERE id_ticket=$idTicket ORDER BY id ASC");
        if ($query != null) {
            return $query;
        }
        return null;
    }
    
    /**
     * 
     * @param int $idTicket
     * @return null | array
     */
    public static function lastDescription($idTicket)
    {
        $data=self::sqlLastDescription($idTicket);
        if ($data != null)
        {
            return $data;
        }
        return null;
    }
    
    /**
     * @param integer $idTicket
     * @return array
     */
    public static function sqlLastDescription($idTicket)
    {
        return self::model()->findBySql(
                  "SELECT *
                  FROM description_ticket 
                  WHERE id_ticket=$idTicket 
                  ORDER BY date DESC, hour DESC");
    }
    
    public static function saveDescription($attributes,$optionOpen,$attributtesFile=null)
    {
        $model=new DescriptionTicket;
        $isOk=true;
        $etelixAsCarrier=false;
        
        $model->id_ticket=$attributes['id_ticket'];
        $model->description=$attributes['description'];
        $model->date=date('Y-m-d');
        $model->hour=date('H:i:s');
        
        if ($optionOpen == 'etelix_as_carrier') {
            $model->id_user=CrugeUser2::getUserTicket($attributes['id_ticket'],true)->iduser;
            $etelixAsCarrier=true;
        } else {
            $model->id_user=Yii::app()->user->id;
        }
        
        $optionRead=self::getUserNewDescription($etelixAsCarrier);
        $model->read_carrier=$optionRead['read_carrier'];
        $model->read_internal=$optionRead['read_internal'];
        $model->response_by=Yii::app()->user->id;
        if (!$model->save()) $isOk=false;
        
        if ($attributtesFile != null){
            if (!File::saveFile($attributtesFile,$model->id)) $isOk=false;
        }
        
        return $isOk;
    }
    
    /**
     * 
     * @param int $idTicket
     * @return string
     */
    public static function blinkTr($idTicket)
    {
        $userLogin=CrugeAuthassignment::getRoleUser();
        $lastDescription=self::lastDescription($idTicket);
        
        if($lastDescription!=null)
        {
            if($userLogin=='C')
            {
                if($lastDescription->read_carrier == '0') 
                {
                    return 'blink';
                }
                return '';
            }
            else
            {
                if($lastDescription->read_internal == '0')
                {
                    return 'blink';
                }
                return '';
            }
        }
    }
    
    /**
     * @param boolean $etelixAsCustomer
     * @param int $idTicket
     * @return array
     */
    public static function getUserNewDescription($etelixAsCustomer=false, $idTicket=false)
    {
        $userLogIn=CrugeAuthassignment::getRoleUser(false, $idTicket);
        if ($etelixAsCustomer) 
        {
            return array('read_carrier'=>'0','read_internal'=>'0');
        } 
        else 
        {
            if($userLogIn === 'C')
            {
                return array('read_carrier'=>'1','read_internal'=>'0');
            } 
            else 
            {
                return array('read_carrier'=>'0','read_internal'=>'1');
            }
        }
    }
}