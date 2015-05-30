<?php

namespace app\models;


use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 * @property integer id
 * @property string name
 * @property string email
 * @property string password_hash
 * @property string db_password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public function init()
    {
        parent::init();
        $this->db_password = \Yii::$app->security->generateRandomString(16);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getDatabases()
    {
        $dbUser = \Yii::$app->params['databasePrefix'] . $this->name;
        $mysqli = new \mysqli('localhost', $dbUser, $this->db_password);
        $prefix = $dbUser . '_';
        $result = $mysqli->query('SHOW DATABASES LIKE \'' . $prefix . '%\'');
        if ($result === false) {
            throw new Exception($mysqli->error);
        }
        $ret = [];
        while ($row = $result->fetch_row()) {
            $dbName = $row[0];
            $ret[substr($dbName, strlen($prefix))] = $dbName;
        }
        return $ret;
    }

    public function getDatabaseUser()
    {
        return \Yii::$app->params['databasePrefix'] . $this->name;
    }

    public function mapDatabaseName($databaseName)
    {
        return $this->getDatabaseUser() . '_' . $databaseName;
    }

    public function getCharts()
    {
        return $this->hasMany(Chart::className(), ['owner_id' => 'id']);
    }
}