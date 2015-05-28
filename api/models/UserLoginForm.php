<?php


namespace app\models;


use yii\base\Model;

/**
 * Class UserLoginForm
 * @package app\models
 * @property User $user
 */
class UserLoginForm extends Model
{
    public $username;
    public $password;

    public $remember_me = false;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'validateUsername'],
            ['password', 'validatePassword'],
        ];
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors())
            if ($this->getUser() === null) {
                $this->addError($attribute, 'User not found.');
            }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getUser(), $this->remember_me ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['name' => $this->_user]);
        }
        return $this->_user;
    }
}