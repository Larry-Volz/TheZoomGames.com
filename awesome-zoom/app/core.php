<?php
namespace app;
class core
{
    private static $_map = [];
    private static $_instance = [];

    // public function __construct() {}

    static public function run()
    {
        // registered AUTOLOAD method
        // spl_autoload_register('app\core::autoload');
        // Define error and exception handling
        // register_shutdown_function('app\core::fatalError');
        // set_error_handler('app\core::appError');
        // set_exception_handler('app\core::appException');
        // require functions/
        self::requireFiles(self::getFiles(CORE_RESOURCES.'functions'.DSE));
        self::autoload();
        new http\controllers\index();
    }

    // Class library automatic loading.
    private function autoload()
    {
        spl_autoload_register(function($class) {
            $fstr = strstr($class,'\\',true);
            $files = APP_CORE.$class.EXT;

            if (!is_file($files)) {
                $files = self::getFiles(dirname($files).DSE);
                $ext = strstr(basename(current($files)), '.');
                $files = APP_CORE.$class.$ext;
            }
            $res = self::requireFiles($files);
        });
    }

    private function requireFiles($files=[])
    {
        $tr['\\'] = DSE;
        $tr['/'] = DSE;
        foreach ((array)$files as $file)
        {
            $file = strtr($file, $tr);
            if (is_file($file))
                require_once($file);
            else
                $fail[$file] = is_file($file);
        }
        return $fail;
    }

    private function getFiles($path=null)
    {
        if ($path === null) return false;
        foreach (scandir($path) as $file)
            if (end(explode('.', $file)) === 'php')
                $ret[] = $path.$file;
        return $ret;
    }

    private function app($class)
    {
        return [
            APP_PATH.end(explode('\\', $class)).EXT,
            APP_PATH.$class.EXT
        ];
    }

    private function config()
    {
        return self::getFiles(APP_CORE.'config'.DSE);
    }

    // Fatal error capture.
    static public function fatalError()
    {
        // Log::save();
        if ($e = error_get_last()) {
            switch($e['type']) {
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    ob_end_clean();
                    // self::halt($e);
                    break;
            }
        }
    }

    // Custom error handling.
    static public function appError($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                ob_end_clean();
                $errorStr = "$errstr ".$errfile." in line $errline.";
                // if(C('LOG_RECORD')) Log::write("[$errno] ".$errorStr,Log::ERR);
                // self::halt($errorStr);
                break;
            default:
                $errorStr = "[$errno] $errstr ".$errfile." in line $errline.";
                self::trace($errorStr,'','NOTIC');
                break;
        }
    }

    // Custom exception handling.
    static public function appException($e)
    {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        // Log::record($error['message'],Log::ERR);
        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        // self::halt($error);
    }
}
