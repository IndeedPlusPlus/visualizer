<?php
namespace app\controllers;

use app\components\JSONController;
use app\models\Chart;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
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
}