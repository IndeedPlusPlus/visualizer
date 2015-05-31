<?php
namespace app\controllers;

use app\components\JSONController;
use app\models\Chart;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ChartController extends JSONController
{
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

    public function actionIndex($database)
    {
        $user = \Yii::$app->user->identity;
        $dbName = $user->mapDatabaseName($database);
        return Chart::findAll(['db_name' => $dbName]);
    }

    public function actionCreate()
    {
        $user = \Yii::$app->user->identity;
        $chart = new Chart();
        if (!empty($this->postData['name']))
            $chart->name = $this->postData['name'];
        if (!empty($this->postData['template']))
            $chart->template = $this->postData['template'];
        if (!empty($this->postData['database']))
            $chart->db_name = $user->mapDatabaseName($this->postData['database']);
        if (!empty($this->postData['query']))
            $chart->query = $this->postData['query'];
        $chart->owner_id = $user->getId();
        if ($chart->save()) {
            return ['status' => 'ok', 'chart' => $chart];
        } else {
            return ['status' => 'error', 'errors' => $chart->errors];
        }
    }

    public function actionView($chartId)
    {
        $chart = Chart::findOne($chartId);
        return $chart;
    }

    public function actionData($chartId)
    {
        $chart = Chart::findOne($chartId);
        if ($chart == null)
            throw new NotFoundHttpException();
        if ($chart->owner->id != \Yii::$app->user->id)
            throw new ForbiddenHttpException();
        $user = \Yii::$app->user->identity;
        $mysqli = new \mysqli('localhost', $user->getDatabaseUser(), $user->db_password, $chart->db_name);
        return $mysqli->query($chart->query)->fetch_all(MYSQL_NUM);
    }

    public function actionQuery($database, $query)
    {
        $user = \Yii::$app->user->identity;
        $dbName = $user->mapDatabaseName($database);
        $mysqli = new \mysqli('localhost', $user->getDatabaseUser(), $user->db_password, $dbName);
        if ($ret = $mysqli->query($query)) {
            return ['status' => 'ok', 'text' => $query, 'first' => $ret->fetch_row(), 'rows' => $ret->num_rows];
        } else {
            return ['status' => 'invalid', 'text' => $query, 'error' => $mysqli->error, 'errors' => $mysqli->error_list];
        }

    }

    public function actionDelete($chartId)
    {
        $chart = Chart::findOne($chartId);
        if ($chart == null)
            throw new NotFoundHttpException();
        if ($chart->owner->id != \Yii::$app->user->id)
            throw new ForbiddenHttpException();
        if ($chart->delete()) {
            return ['status' => 'ok'];
        } else {
            throw new HttpException(500);
        }

    }
}