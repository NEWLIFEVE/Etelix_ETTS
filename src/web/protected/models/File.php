<?php

/**
 * This is the model class for table "file".
 *
 * The followings are the available columns in table 'file':
 * @property integer $id
 * @property integer $id_ticket
 * @property string $saved_name
 * @property string $real_name
 * @property double $size
 * @property string $rute
 * @property integer $id_description_ticket 
 *
 * The followings are the available model relations:
 * @property Ticket $idTicket
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
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
		return 'file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket, saved_name, real_name, size, rute', 'required'),
			array('id_ticket', 'numerical', 'integerOnly'=>true),
			array('size', 'numerical'),
			array('saved_name, real_name', 'length', 'max'=>100),
			array('rute', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_ticket, saved_name, real_name, size, rute', 'safe', 'on'=>'search'),
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
			'idTicket' => array(self::BELONGS_TO, 'Ticket', 'id_ticket'),
                        'idDescriptionTicket' => array(self::BELONGS_TO, 'DescriptionTicket', 'id_description_ticket'),
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
			'saved_name' => 'Saved Name',
			'real_name' => 'Real Name',
			'size' => 'Size',
			'rute' => 'Rute',
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
		$criteria->compare('saved_name',$this->saved_name,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('rute',$this->rute,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function saveFile($attributes,$idDescription)
        {
            $isOk=true;
            $count=count($attributes['_attachFile']);
            for($i=0; $i<$count; $i++)
            {
                $model=new File;
                $model->id_ticket=$attributes['id_ticket'];
                $model->saved_name=$attributes['_attachFileSave'][$i];
                $model->real_name=$attributes['_attachFile'][$i];
                $model->size=0.0;
                $model->rute='uploads/'.$attributes['_attachFileSave'][$i];
                $model->id_description_ticket=$idDescription;
                if (!$model->save()) $isOk=false;
            }
            return $isOk;
        }
}