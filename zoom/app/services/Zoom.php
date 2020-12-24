<?php
namespace app\services;

use app\models\Config;
use app\models\Token;
use Uncgits\ZoomApi\ZoomApiConfig;
use \Uncgits\ZoomApi\Clients\Meetings;
use \Uncgits\ZoomApi\Adapters\Guzzle;
use \Uncgits\ZoomApi\ZoomApi as UncgitsZoomApi;
use \Uncgits\ZoomApi\ZoomApiResult;

class Zoom extends ZoomApiConfig
{
    private static $apis = null;

    public function __construct()
    {
        $this->setApiKey(Config::config('ZOOM_API_KEY'));
        $this->setApiSecret(Config::config('ZOOM_API_SECRET'));

        // Then...

        // generate a token from Firebase library
        // $jwt = $this->refreshToken();
        // OR, set one yourself:

        // ... code that fetches a stored token value from a database or something...
        $this->setJwt(Token::getToken());

        // more likely, you'll write your own method here that calls either $this->refreshToken() or $this->setJwt() depending on whether you determine you need a new token. that logic is up to you!
    }

    static public function api($client=Meetings::class): UncgitsZoomApi
    {
        if (!empty(self::$apis[$client]))
            return self::$apis[$client];
        self::$apis[$client] = new UncgitsZoomApi([
            'client' => $client,
            'adapter' => Guzzle::class,
            'config' => self::class,
        ]);
        return self::$apis[$client];
    }

    static public function status(ZoomApiResult $class): bool
    {
        if ($class === null)
            return false;
        return ($class->status() === 'success');
    }

    static public function langs()
    {
        $dao = new Config;
        if ($langs = $dao->config('ZOOM_LANGS'))
            return json_decode($langs, true);
        $lang['en-us'] = 'English';
        $lang['zh-cn'] = '中文';
        $dao->type = 1;
        $dao->config('ZOOM_LANGS', json_encode($lang));
        return $lang;
    }
}
