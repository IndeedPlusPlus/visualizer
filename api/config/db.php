<?php

return \yii\helpers\ArrayHelper::merge([
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=visualizer',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8'
    ] ,
    include('db.local.php')
);
