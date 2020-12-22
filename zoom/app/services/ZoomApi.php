<?php
namespace app\services;

use app\models\Config;
use Uncgits\ZoomApi\ZoomApiConfig;
use \Uncgits\ZoomApi\Clients\Meetings;
use \Uncgits\ZoomApi\Adapters\Guzzle;
use \Uncgits\ZoomApi\ZoomApi as UncgitsZoomApi;

class ZoomApi extends ZoomApiConfig
{
    public function __construct()
    {
        $this->setApiKey(Config::config('ZOOM_API_KEY'));
        $this->setApiSecret(Config::config('ZOOM_API_SECRET'));

        // Then...

        // generate a token from Firebase library
        $jwt = $this->refreshToken();
        // OR, set one yourself:

        // ... code that fetches a stored token value from a database or something...
        // $this->setJwt();

        // more likely, you'll write your own method here that calls either $this->refreshToken() or $this->setJwt() depending on whether you determine you need a new token. that logic is up to you!
    }

    static public function zoom($client=Meetings::class): UncgitsZoomApi
    {
        return new UncgitsZoomApi([
            'client' => $client,
            'adapter' => Guzzle::class,
            'config' => self::class,
        ]);
    }
}
