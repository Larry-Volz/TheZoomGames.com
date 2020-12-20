<?php
namespace app\drivers;
use app\drivers\Validation;

class Controller
{
    const DENY_METHODS = ['__construct', 'run'];
    const ERRORS = [
        5001 => 'Unknow error!',
        5050 => 'Fatal error!',
        5051 => 'Invalid operation!',
    ];

    private $error = null;
    private $pinfo = null;

    public function __construct() {
        $this->run();
    }

    public function run()
    {
        // if no _SERVER['PATH_INFO']
        if (!isset($_SERVER['PATH_INFO']))
            die(header('Location:index.html'));

        // path info -> method name.
        $this->pinfo = current(explode('/', ltrim($_SERVER['PATH_INFO'], '/')));

        // check if in dead loop method list.
        if (in_array($this->pinfo, self::DENY_METHODS))
            $this->fail(5050);

        // check method exists and call the method.
        $pinfo = $this->pinfo;

        if (method_exists($this, $pinfo))
            $this->$pinfo();
        else
            $this->fail(5051);
    }

    /**
     * $foo: errorCode || errorMessage
     */
    public function fail($foo=null)
    {
        $ecode = key(self::ERRORS);
        $emsg = current(self::ERRORS);
        if ($foo !== null)
        {
            if (self::ERRORS[$foo])
            {
                $emsg = self::ERRORS[$foo];
                $ecode = $foo;
            } else {
                $emsg = $foo;
            }
        } else
            if ($this->error !== null)
                $emsg = $this->error;

        $arr['errorCode'] = $ecode;
        $arr['errorMessage'] = $emsg;
        $arr['method'] = $this->pinfo;
        $arr['result'] = $emsg;
        $arr['status'] = $ecode < 300;
        JsonResponse::error($arr);
    }
}
