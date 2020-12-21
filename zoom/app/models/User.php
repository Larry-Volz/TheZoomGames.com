<?php
namespace app\models;

use think\Model;

class User extends Model
{
    public function addUser($data=null)
    {

    }

    public function getUser($data=null)
    {

    }

    static public function getUserId(): int
    {
        $foo = new self();
        return $foo->where([
            'session_id' => \app\services\User::getSessionId()
        ])->find()->getData('id');
    }
}
