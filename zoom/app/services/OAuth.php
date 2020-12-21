<?php
namespace app\services;

use app\models\User as UserModel;
use app\models\Token;
use app\models\Config;
use app\services\User;
use app\services\Validation;

class OAuth
{
    const ZOOM_OAUTH_AUTHORIZE = 'https://zoom.us/oauth/authorize';
    const ZOOM_OAUTH_TOKEN = 'https://zoom.us/oauth/token';
    static private $authbase = null;

    static private function authorization()
    {
        if (self::$authbase === null)
            self::$authbase = base64_encode(Config::config('ZOOM_CLIENT_ID') . ':' . Config::config('ZOOM_CLIENT_SECRET'));
        return self::$authbase;
    }

    static private function authHeader($foo='Basic ')
    {
        $bar = self::authorization();
        return ["Authorization: $foo $bar"];
    }

    /**
     * Step 1: Request User Authorization.
     */
    static private function authorize()
    {
        $arr[] = 'response_type=code';
        $arr[] = 'redirect_uri=' . Foo::root() . 'getToken';
        $arr[] = 'client_id=' . Config::config('ZOOM_CLIENT_ID');
        $url = self::ZOOM_OAUTH_AUTHORIZE . '?' .  implode('&', $arr);

        if (@$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
        {
            Foo::json([
                'url' => $url
            ]);
        } else {
            header("Location: $url");
            exit("<script>location.href='$url'</script>");
        }
    }

    /**
     * Step 2: Request Access Token.
     */
    public function getToken()
    {
        if (1)
            return false;
        if (Validation::validate(['code' => ['require', 33]]))
        {
            $foo['grant_type'] = 'authorization_code';
            $foo['code'] = $_GET['code'];
            $foo['redirect_uri'] = Foo::root() . 'getToken';
            $url = self::ZOOM_OAUTH_TOKEN;
            $res = json_decode(Foo::httpsCurl($url, $foo, self::authHeader()), true);
            Validation::data($res);

            if (Validation::validate([
                'access_token' => ['require', 642],
                'refresh_token' => ['require', 642],
                'expires_in' => ['require', 'integer'],
            ])) {
                $token = new Token();
                if ($token->saveToken($res)) {
                    // create meeting.
                    dump($res);
                }
                dump($token->getLastSql());
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
        $res = json_decode(Foo::httpsCurl($url, $data, self::authHeader()), true);
    }
}
