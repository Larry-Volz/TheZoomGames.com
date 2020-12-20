<?php
namespace app\models;
use app\drivers\Model;

class User extends Model
{
    private $m = null;
    public function __construct()
    {
        // dump('app\models\User::__construct()');
        // dump($this->db());
        if ($this->m === null)
            $this->m = parent;
        $this->setTable('user');
        return $this;
    }

    public function test()
    {
        dump($this->db());
    }

    public function addUser($data=null)
    {
        if ($data === null)
            return false;

        return $this->m->insert($data);
    }

    public function getUser($data=null)
    {
        if ($data === null)
            return false;

        return $this->m->select($data);
    }
}
