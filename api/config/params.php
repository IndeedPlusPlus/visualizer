<?php

return \yii\helpers\ArrayHelper::merge([
    'adminEmail' => 'admin@example.com',
    'databasePrefix' => 'v_'
    ] ,
    include('params.local.php')
);

