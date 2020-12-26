<?php
namespace app\models;

use think\Model;

class Meeting extends Model
{
    private static $meeting = [];

    public static function saveMeeting(array $arr=[]): bool
    {
        if (empty($arr))
            return false;
        $rule['uuid'] = ['require'];
        $rule['id'] = ['require', 'integer'];
        $rule['password'] = ['require'];
        if (!\app\services\Validation::validate($rule, $arr))
            return false;
        $data['user_id'] = User::getUserId();
        $data['uuid'] = $arr['uuid'];
        $data['meeting_id'] = $arr['id'];
        $data['password'] = $arr['password'];
        $data['start_url'] = $arr['start_url'];
        $data['join_url'] = $arr['join_url'];
        $map['user_id'] = $data['user_id'];
        $bar = new self;
        if ($res = $bar->where($map)->find())
            return $bar->where($map)->replace()->save($data);
        return $bar->replace()->save($data);
    }

    public static function getMeeting(): array
    {
        if (self::$meeting)
            return self::$meeting;
        $bar = new self;
        if ($bar = $bar->where(['user_id' => User::getUserId()])->find())
            self::$meeting = $bar->getData();
        return self::$meeting;
    }

    public static function getPassword($meetingId=null): string
    {
        if ($meetingId !== null)
        {
            $bar = new self;
            if ($bar = $bar->where(['meeting_id' => $meetingId])->find())
                return $bar->getData('password');
        }
        return '';
    }
}
