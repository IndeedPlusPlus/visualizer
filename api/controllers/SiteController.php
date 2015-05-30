<?php

namespace app\controllers;

use app\components\JSONController;
use app\components\SidebarBuilder;
use app\models\User;
use app\models\UserLoginForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class SiteController extends JSONController
{
    public function actionIndex()
    {
        return ['guest' => \Yii::$app->user->isGuest, 'time' => time(), 'user' => \Yii::$app->user->isGuest ? null : \Yii::$app->user->identity->name];
    }

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

        $data = Json::decode(file_get_contents('php://input'));
        if (isset($data['username']))
            $form->username = $data['username'];
        if (isset($data['password']))
            $form->password = $data['password'];
        if (isset($data['remember_me']))
            $form->remember_me = $data['remember_me'];

        if ($form->login()) {
            return ['status' => 'ok', 'username' => $form->getUser()->name ];
        } else {
            Yii::$app->response->statusCode = 403;
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

    public function actionSidebar()
    {
        $builder = new SidebarBuilder();
        $builder->pushHeader();
        if (!Yii::$app->user->isGuest) {
            $submenu = [];
            $databases = Yii::$app->user->identity->getDatabases();
            foreach ($databases as $name => $dbName) {
                $submenu[] = [
                    'text' => $name,
                    'sref' => 'app.dbview',
                    'icon' => 'fa fa-circle-o',
                    'params' => [
                        'name' => $name
                    ]
                ];
            }
            $builder->pushMenu('Databases', null, 'fa fa-database', null, $submenu);
        } else {
            $builder->pushItem('Sign in' , 'page.login' , 'fa fa-sign-in' , null);
        }
        return $builder->toArray();
    }

    public function actionError()
    {
        return [];
    }
}
