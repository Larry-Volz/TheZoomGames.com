<?php
namespace app\drivers;

class File
{
    private $file = null;

    public function __construct()
    {
        return $this;
    }

    public function file($file)
    {
        //
        return $this;
    }

    public function create()
    {
        //
        return true;
    }

    public function delete()
    {
        //
        return true;
    }

    public function getPath($arr=null)
    {
        $tr['/'] = DIRECTORY_SEPARATOR;
        $tr['\\'] = DIRECTORY_SEPARATOR;
        $tr[DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR] = DIRECTORY_SEPARATOR;
        $arr = (array)func_get_args();
        $ret = implode(DIRECTORY_SEPARATOR, $arr);
        if (!basename($ret))
            $ret .= DIRECTORY_SEPARATOR;
        while ($ret !== $foo) {
            if ($foo)
                $ret = $foo;
            $foo = strtr($ret, $tr);
        }
        return $ret;
    }
}
