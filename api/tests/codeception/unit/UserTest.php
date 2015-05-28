<?php
/**
 * Created by IntelliJ IDEA.
 * User: Indeed
 * Date: 5/27/15
 * Time: 9:50 PM
 */

namespace app\tests\codeception\unit;


use app\models\User;

use app\tests\codeception\unit\fixtures\UserFixture;
use yii\codeception\TestCase;

class UserTest extends TestCase
{
    public function fixtures()
    {
        return [
            'users' => UserFixture::className(),
        ];
    }

    public function testCreation()
    {
        $user = new User();
        $user->name = 'test';
        $user->email = 'test@example.com';
        $user->password_hash = \Yii::$app->security->generatePasswordHash('test');
        $this->assertTrue($user->save());
        $this->assertNotNull(User::findOne(['name' => 'test']));
    }

    public function testDelete()
    {
        $this->assertNotNull($user = User::findOne(['name' => 'adam']));
        $user->delete();
        $this->assertNull(User::findOne(['name' => 'adam']));
    }
}
