<?php
namespace app\drivers;

class Model extends Mysql
{
    private $db = null;
    private $sql = null;
    private $table = null;

    public function __construct()
    {
        return new Mysql();
        $this->db = Mysql::db();
    }

    public function db($dsn=null)
    {
        $host = 'localhost';
        $user = 'root';
        $pass = '123123';
        $name = 'awesome_zoom';

        $this->db = new \PDO("mysql:host=$host;dbname=$name;", $user, $pass, [
            \PDO::ATTR_PERSISTENT => true
        ]);
        // $this->db = Mysql::class($host,$user,$pass,$name);
        return $this->db;
    }

    public function createTable()
    {
        // $sql = create
    }

    public function setTable($table=null) {
        $this->table = $table;
    }

    public function getSql() {
        return $this->sql;
    }

    public function insert($data=null)
    {
        if ($data)
        {
            foreach ($data as $field => $value)
                $set[] = "`$field`='$value'";
            $this->sql = "insert ignore into `$this->table` set " . implode(',', $set);
            return $this->exec($this->sql);
        }
        return false;
    }

    public function select($data=null)
    {
        if ($data)
        {
            foreach ($data as $field => $value)
                $where[] = "`$field`='$value'";
            $this->sql = "select * from `$this->table` where " . implode(' AND ', $where);
        }
        return false;
    }
}