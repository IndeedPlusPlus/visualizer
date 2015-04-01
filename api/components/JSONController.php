<?php
namespace app\components;

use yii\web\Controller;
use yii\web\Response;

class JSONController extends Controller
{
    public function init()
    {
        parent::init();
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }
}
