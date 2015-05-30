<?php


namespace app\models;


use yii\db\ActiveRecord;

class Chart extends ActiveRecord
{
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }
}