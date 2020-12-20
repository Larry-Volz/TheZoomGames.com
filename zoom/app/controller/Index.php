<?php
namespace app\controller;

use app\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return 'index';
    }

    public function wtf()
    {
        var_dump('expression');
    }

    public function test()
    {
        var_dump('test');
    }
}
