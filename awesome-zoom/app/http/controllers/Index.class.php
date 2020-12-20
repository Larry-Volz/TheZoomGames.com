<?php
namespace app\http\controllers;
use app\drivers\Controller;
use app\drivers\JsonResponse;
use app\services\OAuth;
use app\services\Jwt;
use app\services\Validation;
use app\services\User;
use \config\Zoom;

class Index extends Controller
{
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * call Jwt::generateSignature().
     */
    public function signature()
    {
        if (Validation::validate([
            'meetingNumber' => ['require', 'integer'],
            'role' => ['require', ['in', [0, 1]]]
        ])) {
            $arr['apiKey'] = Zoom::ZOOM_API_KEY;
            $arr['signature'] = Jwt::generateSignature(
                $arr['apiKey'],
                Zoom::ZOOM_API_SECRET,
                $_POST['meetingNumber'],
                $_POST['role']
            );
            JsonResponse::json($arr);
        } else {
            $this->fail('from validation fail!');
        }
    }

    /**
     * Request Access Token.
     */
    public function getToken()
    {
        OAuth::getToken();
        // $oauth = new OAuth();
        // $oauth->getToken();
    }

    public function refreshToken()
    {
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $YOUR_REFRESH_TOKEN;
        $bar = base64_encode(Zoom::ZOOM_CLIENT_ID . ':' . Zoom::ZOOM_CLIENT_SECRET);
        $header[] = "Authorization: Basic $bar";
    }

    public function test()
    {
        dump('app\http\controllers\index::test()');
        dump($_SERVER);
        dump($_COOKIE);
    }
}