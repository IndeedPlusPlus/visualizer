<?php


namespace app\controllers;


use app\components\JSONController;
use mysqli;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class DatabaseController extends JSONController
{
    protected $dbUser;
    protected $user;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException("not logged in.");
                },
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->user = \Yii::$app->user->identity;
        if ($this->user) {
            $this->dbUser = \Yii::$app->params['databasePrefix'] . $this->user->name;
        }
        return parent::beforeAction($action);
    }

    public function actionCreate($name)
    {
        $dbName = $this->dbUser . '_' . $name;
        $mysqli = new mysqli('localhost', $this->dbUser, $this->user->db_password);

        $ret = $mysqli->query('CREATE DATABASE ' . $dbName . ' CHARSET utf8');
        if ($ret) {
            return ['status' => 'ok'];
        } else {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'error' => $mysqli->error, 'errors' => $mysqli->error_list];
        }
    }

    public function actionDrop($name)
    {
        $dbName = $this->dbUser . '_' . $name;
        $mysqli = new mysqli('localhost', $this->dbUser, $this->user->db_password);

        $ret = $mysqli->query('DROP DATABASE ' . $dbName);
        if ($ret) {
            return ['status' => 'ok'];
        } else {
            \Yii::$app->response->statusCode = 404;
            return ['status' => 'error', 'error' => $mysqli->error, 'errors' => $mysqli->error_list];
        }

    }

    public function actionShowAll()
    {
        return $this->user->getDatabases();
    }
}