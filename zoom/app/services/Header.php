<?php
namespace app\services;

use app\models\Config;

class Header
{
    const HEADER = [
        'Basic ',
        'Bearer ',
    ];
    static private $basic = null;
    static private $bearer = null;

    static private function basic()
    {
        if (self::$basic === null)
            self::$basic = base64_encode(Config::config('ZOOM_CLIENT_ID') . ':' . Config::config('ZOOM_CLIENT_SECRET'));
        return self::$basic;
    }

    static public function headerBasic(): array
    {
        return ['Authorization: Basic ' . self::basic()];
    }

    static public function headerBearer(): array
    {
        return ['Authorization: Bearer ' . \app\models\Token::getToken()];
    }
}