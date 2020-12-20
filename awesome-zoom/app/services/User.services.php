<?php
namespace app\services;
use app\drivers\JsonResponse;
use app\models\User as UserModel;

class User
{
    public function register()
    {
        $user = new UserModel();
        $user->test();
        $data['session_id'] = $_COOKIE['PHPSESSID'];
        setcookie('register', true);
        $ret['data'] = $_COOKIE;
        $ret['_COOKIE'] = $_COOKIE;
        $ret['_REQUEST'] = $_REQUEST;
        JsonResponse::json($ret);
    }
}