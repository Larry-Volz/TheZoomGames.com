<?php
namespace app\drivers;
use PDO;

class Mysql
{
    static private $db = null;
    static private $dsn = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '123123',
        'name' => 'awesome_zoom'
    ];

    public function __construct($host=null,$user=null,$pass=null,$name=null)
    {
        self::$dsn['host'] = $host;
        self::$dsn['user'] = $user;
        self::$dsn['pass'] = $pass;
        self::$dsn['name'] = $name;
        self::db();
        return self;
    }

    public function db()
    {
        $host = self::$dsn['host'];
        $user = self::$dsn['user'];
        $pass = self::$dsn['pass'];
        $name = self::$dsn['name'];

        if (!self::$db)
            self::$db = new PDO("mysql:host=$host;dbname=$name;", $user, $pass, [
                PDO::ATTR_PERSISTENT => true
            ]);
        return self::$db;
    }

    public function exec($sql=null)
    {
        if ($sql === null)
            return false;
        $res = self::db()->query($sql);
        if (self::isError())
            return false;
        foreach ($res as $num => $row)
            foreach ($row as $field => $value)
                if (!is_numeric($field))
                    if (count($row) > 2)
                        $ret[$num][$field] = $value;
                    else
                        $ret[$num] = $value;
        if ($ret === null)
            return true;
        return $ret;
    }

    private function isError()
    {
        $err = self::db()->errorInfo();
        if (($err[0] == 0) && ($err[1] === null) && ($err[2] === null))
            return false;
        else
            return true;
    }

    // public function insert($data=null)
    // {
    //     return self::exec($data);
    // }

    // public function update($data=null)
    // {
    //     return self::exec($data);
    // }

    // public function select($data=null)
    // {
    //     return self::exec($data);
    // }

    // public function delete($data=null)
    // {
    //     return self::exec($data);
    // }
}