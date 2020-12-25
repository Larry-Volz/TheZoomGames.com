<?php
namespace app\controllers;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        // get user info and register session id
        // return redirect('/index.html');
        exit(header('Location: /index.html'));
    }

    public function queryLangs() {
        return json(\app\services\Zoom::langs());
    }

    public function getUser() {
        $foo = new \app\services\User();
        return json($foo->getUser());
    }

    public function startZoom() {
        return json(\app\services\Meeting::startZoom());
    }

    public function checkWaiting() {
        return json(\app\services\Meeting::startZoom());
    }



    public function setName() {
        $foo = new \app\services\User();
        return json($foo->setName());
    }

    public function joinMeeting() {
        $meeting = new \app\services\Meeting();
        return json($meeting->joinMeeting());
    }

    public function inviteMeeting() {
        $meeting = new \app\services\Meeting();
        return json($meeting->inviteMeeting());
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
