<?php
namespace app\services;
use app\drivers\OAuth as OAuthDrivers;
use \config\Zoom;
use app\services\Validation;
use app\services\User;

class OAuth extends OAuthDrivers
{
    const ZOOM_OAUTH_AUTHORIZE = 'https://zoom.us/oauth/authorize';
    const ZOOM_OAUTH_TOKEN = 'https://zoom.us/oauth/token';
    static private $authbase = null;

    private function authorization()
    {
        if (self::$authbase === null)
            self::$authbase = base64_encode(Zoom::ZOOM_CLIENT_ID . ':' . Zoom::ZOOM_CLIENT_SECRET);
        return self::$authbase;
    }

    private function authHeader($foo='Basic ')
    {
        $bar = self::authorization();
        return ["Authorization: $foo $bar"];
    }

    /**
     * Step 1: Request User Authorization.
     */
    private function authorize()
    {
        $arr[] = 'response_type=code';
        $arr[] = 'redirect_uri=' . root() . 'getToken';
        $arr[] = 'client_id=' . Zoom::ZOOM_CLIENT_ID;
        $url = self::ZOOM_OAUTH_AUTHORIZE . '?' .  implode('&', $arr);

        if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
        {
            JsonResponse::json([
                'url' => $url
            ]);
        } else {
            header("Location: $url");
        }
    }

    /**
     * Step 2: Request Access Token.
     */
    public function getToken()
    {
        User::register();

        if (!Validation::validate(['code' => ['require', 33]]))
        {
            $data['grant_type'] = 'authorization_code';
            $data['code'] = $_GET['code'];
            $data['redirect_uri'] = root() . 'getToken';
            $url = self::ZOOM_OAUTH_TOKEN;
            $res = json_decode(httpsCurl($url, $data, self::authHeader()), true);
            Validation::data($res);

            if (Validation::validate([
                'access_token' => ['require', 642],
                'refresh_token' => ['require', 642],
                'expires_in' => ['require', 'integer'],
            ])) {
                // $db = Sqlite::db();
                dump($res);
            } else {
                // dump($res,1,'here');
            }
        } else {
            self::authorize();
        }
    }

    /**
     * Refresh token
     */
    public function refreshToken()
    {
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $YOUR_REFRESH_TOKEN;
        $res = json_decode(httpsCurl($url, $data, self::authHeader()), true);
    }
}
