<?php
namespace app\models;

use think\Model;

class Token extends Model
{
    protected $table = 'oauth_token';
    const EXP_FRESH = '(`create_time` + `expires`) > UNIX_TIMESTAMP()';
    const EXP_EXPIRED = '(`create_time` + `expires`) < UNIX_TIMESTAMP()';

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
        if ($this->where($map)->whereRaw(self::EXP_FRESH)->find())
            return false;
        return true;
    }

    static public function saveToken(array $arr=[]): bool
    {
        if (empty($arr))
            return false;
        $rule['access_token'] = ['require'];
        $rule['refresh_token'] = ['require'];
        $rule['expires_in'] = ['require', 'integer'];
        $rule['token_type'] = ['require'];
        if (!\app\services\Validation::validate($rule, $arr))
            return false;
        $data['user_id'] = User::getUserId();
        $data['token_type'] = $arr['token_type'];
        $data['access_token'] = $arr['access_token'];
        $data['refresh_token'] = $arr['refresh_token'];
        $data['expires'] = $arr['expires_in'];
        $data['create_time'] = $_SERVER['REQUEST_TIME'];
        $map['user_id'] = $data['user_id'];
        $bar = new self;
        if ($res = $bar->where($map)->find())
            return $bar->where($map)->save($data);
        return $bar->save($data);
    }

    static private function getTokens(string $field='access_token'): string
    {
        $bar = new self;
        $map['user_id'] = User::getUserId();
        $bar = $bar->where($map)->whereRaw(self::EXP_FRESH);
        $bar = $bar->field('access_token')->find();
        if ($bar)
            return $bar->getData('access_token');
        return '';
    }

    static public function getToken(): string
    {
        return self::getTokens('access_token');
    }

    static public function getRefreshToken(): string
    {
        return self::getTokens('refresh_token');
    }
}