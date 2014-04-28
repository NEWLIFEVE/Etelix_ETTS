<?php

/**
 * This is the model class for table "failure_speech".
 *
 * The followings are the available columns in table 'failure_speech':
 * @property integer $id
 * @property integer $id_failure
 * @property integer $id_speech
 *
 * The followings are the available model relations:
 * @property Failure $idFailure
 * @property Speech $idSpeech
 */
class FailureSpeech extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'failure_speech';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_failure, id_speech', 'required'),
			array('id_failure, id_speech', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_failure, id_speech', 'safe', 'on'=>'search'),
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
			'idFailure' => array(self::BELONGS_TO, 'Failure', 'id_failure'),
			'idSpeech' => array(self::BELONGS_TO, 'Speech', 'id_speech'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_failure' => 'Id Failure',
			'id_speech' => 'Id Speech',
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
		$criteria->compare('id_failure',$this->id_failure);
		$criteria->compare('id_speech',$this->id_speech);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FailureSpeech the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
