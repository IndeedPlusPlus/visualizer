<?php
namespace app\components;

use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class JSONController extends Controller
{
    protected $postData;

    public function init()
    {
        parent::init();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $postString = file_get_contents('php://input');
        if ($postString)
            $this->postData = Json::decode($postString);
    }
}
