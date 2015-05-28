<?php

use yii\db\Migration;
use yii\db\Schema;

class m150527_133143_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'password_hash' => Schema::TYPE_STRING
        ]);
        $this->createIndex('user_name_unique', 'user', 'name', true);
        $this->createIndex('user_email_unique', 'user', 'email', true);
    }

    public function down()
    {
        $this->dropTable('user');
    }

}
