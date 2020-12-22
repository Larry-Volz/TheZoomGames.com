<?php
namespace app\models;

use think\Model;

class User extends Model
{
    static public function getUserId(): int
    {
        $foo = new self();
        return $foo->where([
            'session_id' => \app\services\User::getSessionId()
        ])->find()->getData('id');
    }
}
