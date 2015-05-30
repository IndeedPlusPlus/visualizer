<?php
namespace app\controllers;

use app\components\JSONController;
use app\models\Chart;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ChartController extends JSONController
{
    public function actionIndex()
    {

    }

    public function actionCreate()
    {

    }

    public function actionData($chartId)
    {
        $chart = Chart::findOne($chartId);
        if ($chart == null)
            throw new NotFoundHttpException();
        if ($chart->owner->id != \Yii::$app->user->id)
            throw new ForbiddenHttpException();
        $user = \Yii::$app->user->identity;
        $mysqli = new \mysqli('localhost' , $user->getDatabaseUser(), $user->db_password, $chart->db_name);
        return $mysqli->query($chart->query)->fetch_all(MYSQL_NUM);
    }
}