<?php
namespace app\models;

use think\Model;

class User extends Model
{
    private static $id = 0;

    static public function getUserId(): int
    {
        if (self::$id)
            return self::$id;
        $foo = new self;
        $foo = $foo->where([
            'session_id' => \app\services\User::getSessionId()
        ])->find();
        if ($foo)
            self::$id = $foo->getData('id');
        return self::$id;
    }
}
