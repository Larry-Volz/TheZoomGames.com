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
/*
        $uarr = \app\services\User::user();
        if ($uarr) {
            $foo = \app\services\Zoom::api();
            dump($foo->listMeetings($uarr['id']));
        }
*/
        dump(\app\services\User::user());
        dump(\app\services\Meeting::queryMeeting());
        dump(\app\services\Meeting::createMeetings());
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

    public function requestToken() {
        $oauth = new \app\services\OAuth();
        $oauth->requestToken();
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
