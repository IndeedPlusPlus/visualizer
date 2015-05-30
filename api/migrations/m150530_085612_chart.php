<?php

use yii\db\Schema;
use yii\db\Migration;

class m150530_085612_chart extends Migration
{
    public function up()
    {
        $this->createTable('chart' , [
           'id' => Schema::TYPE_PK,
            'owner_id' => Schema::TYPE_INTEGER,
            'db_name' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING,
            'template' => Schema::TYPE_STRING,
            'query' => Schema::TYPE_STRING,
        ]);
        $this->createIndex('chart_owner_id' , 'chart' , 'owner_id');
        $this->createIndex('chart_db_name' , 'chart' , 'db_name');
        $this->addForeignKey('chart_owner','chart','owner_id','user','id');
    }

    public function down()
    {
        $this->dropTable('chart');
    }

}
