<?php

/**
 * This is the model class for table "answer_ticket".
 *
 * The followings are the available columns in table 'answer_ticket':
 * @property integer $id
 * @property integer $id_ticket
 * @property string $answer
 * @property string $date
 * @property string $hour
 */
class AnswerTicket extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnswerTicket the static model class
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
		return 'answer_ticket';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket, answer, date', 'required'),
			array('id_ticket', 'numerical', 'integerOnly'=>true),
			array('hour', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_ticket, answer, date, hour', 'safe', 'on'=>'search'),
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
			'answer' => 'Answer',
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
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hour',$this->hour,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}