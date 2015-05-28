<?php

namespace app\controllers;

use app\components\JSONController;
use app\models\User;
use app\models\UserLoginForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

class SiteController extends JSONController
{
    public function actionStatus()
    {
        define('DB_PREFIX', \Yii::$app->params['databasePrefix']);
        $databases = ArrayHelper::getColumn(
            \Yii::$app->db->createCommand("SHOW DATABASES LIKE '" . DB_PREFIX . "'")->queryAll(),
            'Database');
        return ['status' => 'ok', 'databasesCount' => count($databases)];
    }

    public function actionLogin()
    {
        $form = new UserLoginForm();
        $form->username = Yii::$app->request->post('username');
        $form->password = Yii::$app->request->post('password');
        if ($form->login()) {
            return ['status' => 'ok', 'username' => $form->getUser()->name];
        } else {
            return ['status' => 'error', 'errors' => $form->getErrors()];
        }
    }

    public function actionBypass($username)
    {
        if (YII_ENV_DEV) {
            $user = User::findOne(['name' => $username]);
            Yii::$app->user->login($user);
            return ['status' => 'bypass'];
        }
        throw new ForbiddenHttpException();
    }
}
