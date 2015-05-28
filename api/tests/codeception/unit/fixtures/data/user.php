<?php
return [
    'user1' => [
        'name' => 'adam',
        'email' => 'adam@example.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('adam233'),
        'db_password' => 'adam_db',
    ],
    'user2' => [
        'name' => 'john',
        'email' => 'john@example.com',
        'password_hash' => Yii::$app->security->generatePasswordHash('john1'),
        'db_password' => 'john_db',
    ],
];