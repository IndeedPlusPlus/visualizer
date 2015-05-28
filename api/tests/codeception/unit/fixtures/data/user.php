<?php
return [
    'user1' => [
        'name' => 'adam',
        'email' => 'adam@example.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('adam233'),
    ],
    'user2' => [
        'name' => 'john',
        'email' => 'john@example.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('john1'),
    ],
];