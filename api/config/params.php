<?php

return \yii\helpers\ArrayHelper::merge([
    'adminEmail' => 'admin@example.com',
    'databasePrefix' => 'v_',
    'pmaSessionName' => 'PMA_SESSION',
    'pmaURL' => '/pma/',
    'pmaHost' => 'localhost'
],
    include('params.local.php')
);

