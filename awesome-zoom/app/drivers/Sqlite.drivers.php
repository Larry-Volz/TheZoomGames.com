<?php
namespace app\drivers;
use PDO;

class Sqlite
{
    static private $filename = null;
    private $db = null;
    private $migrations = '';

    //
    public function __construct()
    {
        self::createFile();
        return self;
    }

    private function filename()
    {
        if (self::$filename === null)
        {
            $root = dirname(APP_ROOT).DIRECTORY_SEPARATOR;
            $filename = $root.APP_NAME.'.database.sqlite';
            self::$filename = $filename;
        }
        return self::$filename;
    }

    private function createFile()
    {
        if (!is_file(self::filename()))
            if (false === file_put_contents(self::filename(), ''))
                die('cannot create sqlite file!');
    }

    public function db()
    {
        $file = self::filename();
        self::$db = new PDO("sqlite:$file");
        return self::$db;
    }

    public function untitled()
    {
        $query = "CREATE TABLE IF NOT EXISTS students (name STRING, email STRING)";
        self::db()->exec($query);
    }
}