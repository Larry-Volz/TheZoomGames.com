<?php
namespace app\drivers;

class Model extends Sqlite
{
    private $db = null;

    public function __construct()
    {
        return $this->db();
    }

    public function db()
    {
        $this->db = Sqlite::db();
        return $this->db;
    }

    public function createTable()
    {
        // $sql = create
    }


}