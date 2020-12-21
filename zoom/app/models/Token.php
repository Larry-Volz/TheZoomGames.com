<?php
namespace app\models;

use think\Model;

class Token extends Model
{
    protected $table = 'oauth_token';

    public function save(array $data=[], string $sequence=null): bool
    {
        if (!$this->checkUnique($data))
            return false;
        return parent::save($data, $sequence);
    }

    private function checkUnique(array $data=[]): bool
    {
        if (empty($data['user_id']))
            return false;

        $map['user_id'] = $data['user_id'];
        $exp = '(`create_time` + `expires`) > UNIX_TIMESTAMP()';
        $sql = $this->where($map)->whereRaw($exp)->fetchSql(true)->find();
        dump($sql);
        if ($this->where($map)->whereRaw($exp)->find())
            return false;
        return true;
    }

    public function saveToken(array $arr=[]): bool
    {
        if (empty($arr))
            return false;

        $user = new User();
        $map['session_id'] = \app\services\User::getSessionId();
        $data['user_id'] = $user->where($map)->find()->getData('id');
        $data['token_type'] = $arr['token_type'];
        $data['access_token'] = $arr['access_token'];
        $data['refresh_token'] = $arr['refresh_token'];
        $data['expires'] = $arr['expires_in'];
        $data['create_time'] = $_SERVER['REQUEST_TIME'];
        $tMap['user_id'] = $data['user_id'];

        if ($res = $this->where($tMap)->find())
            return $this->where($tMap)->save($data);
        return $this->save($data);
    }

    public function getToken()
    {
        $map['session_id'] = $_COOKIE
    }
}