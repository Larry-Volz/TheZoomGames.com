<?php
namespace app\controllers;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        // get user info and register session id
        // return redirect('/index.html');
        // header('Location: /index.html');
        $obj = new \app\models\Token();
        $exp = '(`create_time` + `expires`) > UNIX_TIMESTAMP()';
        $sql = $obj->whereRaw($exp)->fetchSql(true)->find();
        dump($sql);
        $f = "create_time,FROM_UNIXTIME((`create_time` + `expires`), '%H:%i:%s') as expires_time";
        $f .= ",FROM_UNIXTIME(UNIX_TIMESTAMP(),'%H:%i:%s') as `now`";
        dump($obj->field($f)->whereRaw($exp)->select()->toArray());
        dump($obj->field($f)->select()->toArray());
        $data['user_id'] = '1';
        $res = $obj->save($data);
        dump($res);
        exit;
    }

    public function test() {
        $obj = new \app\models\Config();
        // dump($obj->config('ZOOM_API_KEY').time());
        // dump($obj->config('ZOOM_API_KEY_1', 'ZOOM_API_KEY_1'));
        exit;
        $u = new \app\services\User();
        return json($u->getUser());
    }

    public function getUser() {
        $foo = new \app\services\User();
        return json($foo->getUser());
    }

    public function setName() {
        $foo = new \app\services\User();
        return json($foo->setName());
    }

    public function getToken() {
        $oauth = new \app\services\OAuth();
        $oauth->getToken();
    }

    public function refreshToken() {
        $oauth = new \app\services\OAuth();
        $oauth->refreshToken();
    }

    public function createMeeting() {
        $foo = new \app\services\Meeting();
        return json($foo->createMeeting());
    }

    public function match() {
        $foo = new \app\services\Meeting();
        return json($foo->match());
    }

    public function joinMeeting() {
        $meeting = new \app\services\Meeting();
        return json($meeting->joinMeeting());
    }
}
