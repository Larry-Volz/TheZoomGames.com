<?php
namespace app\services;
use app\drivers\JsonResponse;
use app\drivers\Validation;
use app\models\User as UserModel;

class User
{
    const CKEY = 'awesomezoom';
    private $user = null;

    public function __construct()
    {
        if ($this->user === null)
            $this->user = new UserModel();
    }

    public function register()
    {
        if ($_COOKIE[self::CKEY])
            return false;

        if (!Validation::validate([
            'name' => ['require']
        ]))
            return false;

        $data['session_id'] = self::genSession();
        $data['name'] = $_GET['name'];
        $data['create_time'] = time();
        $res = $this->user->addUser($data);

        if ($res)
            setcookie(self::CKEY, $data['session_id']);
    }

    public function genSession() {
        return md5(time().rand(1000,9999));
    }

    public function getUser()
    {
        $ret['errorCode'] = 0;
        $ret['errorMessage'] = 'new user';

        if ($_COOKIE[self::CKEY])
            JsonResponse::error($ret);

        $res = $this->user->getUser(['session_id' => $_COOKIE[self::CKEY]]);

        if ($res)
            JsonResponse::json($res);
        else {
            $ret['errorCode'] = 2;
            $ret['errorMessage'] = 'user not found';
            JsonResponse::error($ret);
        }
    }
}