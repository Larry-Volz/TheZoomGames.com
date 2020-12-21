<?php
namespace app\models;

use think\Model;

class Config extends Model
{
    static private $cache = null;

    static public function config($name=null,$value=null)
    {
        if ($name === null)
            return false;
        if (!empty(self::$cache[$name]))
            return self::$cache[$name];
        $map['key'] = $name;
        $foo = new self;
        if ($value !== null) {
            $val['value'] = $value;
            return $foo->save(array_merge($map, $val));
        } else {
            $res = $foo->where($map)->find();

            if ($res)
                return self::$cache[$name] = $res->value;
            else
                return self::$cache[$name];
        }
    }
}