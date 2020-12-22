<?php
namespace app\services;

class ZoomUser
{
    const ZOOM_BASE = 'https://api.zoom.us/v2';
    const ZOOM_USERS = 'https://api.zoom.us/v2/users';

    static public function users(bool $one=false): array
    {
        $res = json_decode(Foo::httpsCurl(self::ZOOM_USERS, null, Header::headerBearer()), true);
        if (empty($res['users']))
            return [];
        if ($one === true)
            return $res['users'][0];
        return $res;
    }

    static public function user()
    {
        return self::users(true);
    }
}