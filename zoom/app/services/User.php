<?php
namespace app\services;

use app\models\User as UserModel;
use app\services\Json;

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

        $data['session_id'] = $this->genSessionId();
        $data['create_time'] = time();
        $res = $this->user->save($data);

        if (@$res) {
            setcookie(self::CKEY, $data['session_id']);
            return ['session_id' => $data['session_id']];
        }
    }

    public function setName()
    {
        if (!$sid = $this->hasSessionId()) {
            $ret['errorCode'] = '1002';
            $ret['errorMessage'] = 'something wrong, try again.';
            Json::error($ret);
        }

        if (empty($_POST['name'])) {
            $ret['errorCode'] = '1003';
            $ret['errorMessage'] = 'name required!';
            Json::error($ret);
        }

        $data['name'] = $_POST['name'];
        $res = $this->user->save($data);
        if ($res)
            setcookie(self::CKEY, $data['session_id']);
    }

    public function genSessionId() {
        $res = md5(time().rand(1000,9999));
        if ($this->user->where(['session_id'=>$res])->find())
            return $this->genSessionId();
        return $res;
    }

    public function hasSessionId() {
        if (!empty($_COOKIE[self::CKEY]))
            return $_COOKIE[self::CKEY];
        if (!empty($_POST[self::CKEY]))
            return $_POST[self::CKEY];
        if (!empty($_GET[self::CKEY]))
            return $_GET[self::CKEY];
    }
}
