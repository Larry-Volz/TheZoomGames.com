<?php
namespace app\services;

use app\models\User as UserModel;
use \Uncgits\ZoomApi\Clients\Users;

class User
{
    const CKEY = 'awesomezoom';
    const ZOOM_BASE = 'https://api.zoom.us/v2';
    const ZOOM_USERS = 'https://api.zoom.us/v2/users';
    private static $userModel = null;
    private static $session_id = '';
    private static $zoomUser = null;

    private static function userModel()
    {
        if (self::$userModel === null)
            self::$userModel = new UserModel;
        return self::$userModel;
    }

    // zoom users
    public static function users(bool $one=false): array
    {
        $res = json_decode(Foo::httpsCurl(self::ZOOM_USERS, null, Header::headerBearer()), true);
        if (empty($res['users']))
            return [];
        if ($one === true)
            return $res['users'][0];
        return $res;
    }

    // zoom user
    public static function user()
    {
        if (self::$zoomUser)
            return self::$zoomUser;
        $zoom = Zoom::api(Users::class);
        $zoom = $zoom->listUsers();
        if ($zoom->status() !== 'success')
            return false;
        self::$zoomUser = current($zoom->content());
        return self::$zoomUser;
    }

    public static function getUser()
    {
        if (self::$session_id)
            return ['session_id' => self::$session_id];
        $bar = self::userModel();

        if ($map['session_id'] = self::hasSessionId()) {
            $bar = $bar->where($map)->findOrEmpty();
            if (!$bar->isEmpty()) {
                self::$session_id = $bar->getData('session_id');
                return ['session_id' => self::$session_id];
            }
        }

        $data['session_id'] = self::genSessionId();
        $data['create_time'] = time();
        $bar = $bar->save($data);

        if (!empty($bar)) {
            setcookie(self::CKEY, $data['session_id']);
            self::$session_id = $data['session_id'];
            return ['session_id' => $data['session_id']];
        }
    }

    public function setName()
    {
        $bar = self::userModel();
        if (!$sid = self::hasSessionId())
            Foo::error('something wrong, try again.', 1002);
        if (empty($_POST['name']))
            Foo::error('name required!', 1003);
        $map['session_id'] = $sid;
        $data['name'] = $_POST['name'];
        return true;
        $bar = $bar->where($map)->save($data);
        if (!empty($bar))
            setcookie(self::CKEY, $map['session_id']);
        else
            Foo::error('Failed to save data!', 1004);
        return $data;
    }

    public static function genSessionId()
    {
        $res = md5(time().rand(1000,9999));
        $foo = new self::$userModel;
        if ($foo->field('id')->where(['session_id'=>$res])->find())
            return self::genSessionId();
        return $res;
    }

    public static function hasSessionId(): string
    {
        if (!empty($_COOKIE[self::CKEY]))
            return $_COOKIE[self::CKEY];
        if (!empty($_POST[self::CKEY]))
            return $_POST[self::CKEY];
        if (!empty($_GET[self::CKEY]))
            return $_GET[self::CKEY];
        return '';
    }

    public static function getSessionId(): string
    {
        if (self::$session_id)
            return self::$session_id;
        $foo = self::userModel();
        if ($map['session_id'] = self::hasSessionId())
            if ($foo = $foo->field('session_id')->where($map)->find())
                self::$session_id = $foo->getData('session_id');
        return self::$session_id;
    }
}
