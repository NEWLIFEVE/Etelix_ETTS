<?php

/**
 * This is the model class for table "tested_number".
 *
 * The followings are the available columns in table 'tested_number':
 * @property integer $id
 * @property integer $id_ticket
 * @property integer $id_country
 * @property integer $numero
 * @property string $date
 * @property string $hour
 *
 * The followings are the available model relations:
 * @property Country $idCountry
 * @property Ticket $idTicket
 */
class TestedNumber extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TestedNumber the static model class
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
		return 'tested_number';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket, id_country, numero, date', 'required'),
			array('id_ticket, id_country, numero', 'numerical', 'integerOnly'=>true),
			array('hour', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_ticket, id_country, numero, date, hour', 'safe', 'on'=>'search'),
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
			'idCountry' => array(self::BELONGS_TO, 'Country', 'id_country'),
			'idTicket' => array(self::BELONGS_TO, 'Ticket', 'id_ticket'),
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
			'id_country' => 'Id Country',
			'numero' => 'Numero',
			'date' => 'Date',
			'hour' => 'Hour',
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
		$criteria->compare('id_country',$this->id_country);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hour',$this->hour,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public static function getNumbers($idTicket = false)
        {
            if ($idTicket) {
                return self::model()->findAll("id_ticket = $idTicket");
            } else {
                return self::model()->findAll();
            }
        }
        
        public static function getTestedNumberArray($idTicket)
        {
            $array = null;
            $numbers=self::getNumbers($idTicket);
            if ($numbers != null) {
                foreach ($numbers as $key => $value){
                    $array['number'][] = $value->numero;
                    $array['country'][] = $value->idCountry->name;
                    $array['date'][] = $value->date;
                    $array['hour'][] = $value->hour;
                } 
            }
            return  $array;
        }
        
        public static function saveTestedNumbers($attributes)
        {
            $model=new TestedNumber;
            $isOk=true;
            $count=count($attributes['testedNumber']);
            for($i=0; $i<$count; $i++)
            {
                $model->id_ticket=$attributes['id_ticket'];
                $model->id_country=$attributes['_country'][$i];
                $model->numero=$attributes['testedNumber'][$i];
                $model->date=$attributes['_date'][$i];
                $model->hour=$attributes['_hour'][$i];
                if (!$model->save())
                    $isOk = false;
            }
            return $isOk;
        }
}