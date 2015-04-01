<?php

namespace app\controllers;

use app\components\JSONController;
use Yii;
use yii\helpers\ArrayHelper;

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
}
