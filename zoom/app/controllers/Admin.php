<?php
namespace app\controllers;

// use app\BaseController;
use \app\models\Config;
use think\facade\View;

// class Index extends BaseController
class Admin
{
    public function index() {
        return View::fetch();
    }

    public function list()
    {
        $dao = new Config;
        $res = $dao->where('key','not in','ZOOM_LANGS')->select();
        return json($res->toArray());
    }

    public function save()
    {
        $dao = new Config;
        if ($dao->replace()->save($_POST))
            return 'success';
        else
            return 'fail';
    }
}