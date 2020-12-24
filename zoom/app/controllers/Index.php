<?php
namespace app\controllers;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        dump(self::class.'index()');
        // get user info and register session id
        // return redirect('/index.html');
        // header('Location: /index.html');
        // exit;
        // dump(\app\services\Meeting::queryMeeting());
        dump(\app\services\Meeting::createMeetings());
    }

    public function queryLangs() {
        return json(\app\services\Zoom::langs());
    }

    public function getUser() {
        $foo = new \app\services\User();
        return json($foo->getUser());
    }

    public function setName() {
        $foo = new \app\services\User();
        return json($foo->setName());
    }

    public function joinMeeting() {
        $meeting = new \app\services\Meeting();
        return json($meeting->joinMeeting());
    }

    public function requestToken() {
        return \think\facade\View::fetch(\app\services\OAuth::requestToken());
    }

    public function refreshToken() {
        $oauth = new \app\services\OAuth();
        $oauth->refreshToken();
    }

    public function match() {
        $foo = new \app\services\Meeting();
        return json($foo->match());
    }
}
