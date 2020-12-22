<?php
namespace app\services;

use app\models\User as UserModel;
// use app\services\Foo;

class User
{
    const CKEY = 'awesomezoom';
    private $user = null;

    public function __construct()
    {
        if ($this->user === null)
            $this->user = new UserModel();
    }

    public function getUser()
    {
        $map['session_id'] = $this->hasSessionId();

        if (!empty($map)) {
            $res = $this->user->where($map)->findOrEmpty();
            if (!$res->isEmpty())
                return $res->getData();
        }

        $data['session_id'] = self::genSessionId();
        $data['create_time'] = time();
        $res = $this->user->save($data);

        if (!empty($res)) {
            setcookie(self::CKEY, $data['session_id']);
            return ['session_id' => $data['session_id']];
        }
    }

    public function setName()
    {
        if (!$sid = $this->hasSessionId()) {
            $ret['errorCode'] = 1002;
            $ret['errorMessage'] = 'something wrong, try again.';
            Foo::error($ret);
        }

        if (empty($_POST['name'])) {
            $ret['errorCode'] = 1003;
            $ret['errorMessage'] = 'name required!';
            Foo::error($ret);
        }

        $map['session_id'] = $sid;
        $data['name'] = $_POST['name'];
        return true;
        $res = $this->user->where($map)->save($data);
        if (!empty($res))
            setcookie(self::CKEY, $map['session_id']);
        else {
            $ret['errorCode'] = 1004;
            $ret['errorMessage'] = 'Failed to save data!';
            Foo::error($ret);
        }

        return $data;
    }

    static public function genSessionId() {
        $res = md5(time().rand(1000,9999));
        $foo = new self();
        if ($foo->user->field('id')->where(['session_id'=>$res])->find())
            return self::genSessionId();
        return $res;
    }

    static public function hasSessionId(): string
    {
        if (!empty($_COOKIE[self::CKEY]))
            return $_COOKIE[self::CKEY];
        if (!empty($_POST[self::CKEY]))
            return $_POST[self::CKEY];
        if (!empty($_GET[self::CKEY]))
            return $_GET[self::CKEY];
        return '';
    }

    static public function getSessionId(): string
    {
        $foo = new self();
        if ($map['session_id'] = self::hasSessionId())
            return $foo->user->field('session_id')->where($map)->find()->getData('session_id');
        return '';
    }
}
