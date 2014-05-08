<?php
/**
 * @author Nelson
 */
class NActiveRecord extends CActiveRecord 
{
    public static $soriDB;

    public static function getDatos1DbConnection()
    {
        if (self::$soriDB !== null) {
            return self::$soriDB;
        } else {
            self::$soriDB = Yii::app()->soriDB;
            
            if (self::$soriDB instanceof CDbConnection) {
                self::$soriDB->setActive(true);
                return self::$soriDB;
            } else {
                throw new CDbException(Yii::t('yii', 'Error en Active Record'));
            }
        }
    }
}