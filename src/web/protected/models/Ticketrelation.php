<?php

/**
 * This is the model class for table "ticket_relation".
 *
 * The followings are the available columns in table 'ticket_relation':
 * @property integer $id
 * @property integer $id_ticket_father
 * @property integer $id_ticket_son
 *
 * The followings are the available model relations:
 * @property Ticket $idTicketFather
 * @property Ticket $idTicketSon
 */
class Ticketrelation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ticket_relation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ticket_father, id_ticket_son', 'required'),
			array('id_ticket_father, id_ticket_son', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_ticket_father, id_ticket_son', 'safe', 'on'=>'search'),
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
			'idTicketFather' => array(self::BELONGS_TO, 'Ticket', 'id_ticket_father'),
			'idTicketSon' => array(self::BELONGS_TO, 'Ticket', 'id_ticket_son'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_ticket_father' => 'Id Ticket Father',
			'id_ticket_son' => 'Id Ticket Son',
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
		$criteria->compare('id_ticket_father',$this->id_ticket_father);
		$criteria->compare('id_ticket_son',$this->id_ticket_son);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ticketrelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public static function getTicketRelation($idTicketFather = false, $returnArray = false)
        {
            if ($returnArray) {
                $ticket = self::model()->findAll("id_ticket_father = $idTicketFather");
            } else {
                $ticket = self::model()->find("id_ticket_father = $idTicketFather");
            }
            
            if ($ticket != null)
                return $ticket;
            else
                return null;
        }
        
}
