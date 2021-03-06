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
        foreach ($_POST as $key => $value)
            $data[] = ['key' => $key, 'value' => $value];
        if ($dao->replace()->saveAll($data))
            return 'success<script>setTimeout(function(){location.href="index"},3000)</script>';
        else
            return 'fail<script>setTimeout(function(){location.href="index"},3000)</script>';
    }

    public function database()
    {
        if (!empty($_GET['table']))
            Db::query('TRUNCATE `'.$_GET['table'].'`');
        $ret = [];
        $dao = new Config;
        $res = Db::query('show tables;');
        $tables[] = 'zoom_config';
        $tables[] = 'zoom_meeting';
        $tables[] = 'zoom_oauth_token';
        $tables[] = 'zoom_user';
        foreach ($res as $row) {
            if (!in_array(current($row), $tables))
                continue;
            $sql = 'select * from ' . current($row);
            $ret[current($row)] = Db::query($sql);
        }
        View::assign(['data'=>$ret]);
        return View::fetch();
    }
}