<?php

/**
 * This is the model class for table "cruge_authassignment".
 *
 * The followings are the available columns in table 'cruge_authassignment':
 * @property integer $userid
 * @property string $bizrule
 * @property string $data
 * @property string $itemname
 */
class CrugeAuthassignment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cruge_authassignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, itemname', 'required'),
			array('userid', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>64),
			array('bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, bizrule, data, itemname', 'safe', 'on'=>'search'),
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
			'userid' => 'Userid',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
			'itemname' => 'Itemname',
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

		$criteria->compare('userid',$this->userid);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('itemname',$this->itemname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CrugeAuthassignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Método para retornar el rol de usuarios, si el primer parametro es true
         * se retornará el nombre completo del rol, de lo contrario solo retorna
         * la primera letra del rol
         * 
         * @param boolean $nameFull
         * @param int $userId
         * @return string
         */
        public static function getRoleUser($nameFull = false, $userId = false)
        {
            if ($userId) {
                $userId = $userId;
            } else {
                $userId = Yii::app()->user->id;
            }
            
            $role = self::model()->find("userid=" . $userId);
            
            if ($role != null) {
                if ($nameFull) 
                    return $role->itemname;
                else 
                    return substr(ucfirst($role->itemname), 0, 1);
            } else {
                if ($nameFull) 
                    return 'admin';
                else
                    return 'A';
            }
        }
}
