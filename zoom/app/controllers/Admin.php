<?php
namespace app\controllers;

// use app\BaseController;
use \app\models\Config;
use think\facade\View;
use think\facade\Db;

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

    public function database()
    {
        if (!empty($_GET['table']))
            Db::query('TRUNCATE `'.$_GET['table'].'`');
        $dao = new Config;
        $res = Db::query('show tables;');
        foreach ($res as $row) {
            $sql = 'select * from ' . current($row);
            $ret[current($row)] = Db::query($sql);
        }
        View::assign(['data'=>$ret]);
        return View::fetch();
    }
}