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
        if (($value === null) && !empty(self::$cache[$name]))
            return self::$cache[$name];
        $map['key'] = $name;
        $foo = new self;
        if ($value !== null) {
            $val['value'] = $value;
            return $foo->replace()->save(array_merge($map, $val));
        } else {
            $res = $foo->where($map)->find();
            if ($res)
                return self::$cache[$name] = $res->value;
            else
                return null;
        }
    }

    static public function setConfig($name=null,$value=null)
    {
        if (empty($name) || empty($value))
            return false;
        $data['key'] = $name;
        $data['value'] = $value;
        $foo = new self;
        return $foo->save($data);
    }

    static public function getConfig($name=null)
    {
        if ($name === null)
            return false;
        if (!empty(self::$cache[$name]))
            return self::$cache[$name];
        $map['key'] = $name.'A';
        $foo = new self;
        return $foo->where($map)->find()->getDate();
    }

    static public function removeConfig($name=null)
    {
        // if
    }

}