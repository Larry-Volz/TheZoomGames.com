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

    /**
     * Step 1: Request User Authorization.
     */
    static private function authorize()
    {
        $arr[] = 'response_type=code';
        $arr[] = 'redirect_uri=' . Foo::root() . 'requestToken';
        $arr[] = 'client_id=' . Config::config('ZOOM_CLIENT_ID');
        $url = self::ZOOM_OAUTH_AUTHORIZE . '?' .  implode('&', $arr);

        if (@$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            Foo::json(['url' => $url]);
        } else {
            header("Location: $url");
            exit("<script>location.href='$url'</script>");
        }
    }

    /**
     * Step 2: Request Access Token.
     */
    public function requestToken()
    {
        if (0)
            return false;
        if (Validation::validate(['code' => ['require', 33]]))
        {
            $foo['grant_type'] = 'authorization_code';
            $foo['code'] = $_GET['code'];
            $foo['redirect_uri'] = Foo::root() . 'requestToken';
            $url = self::ZOOM_OAUTH_TOKEN;
            $res = json_decode(Foo::httpsCurl($url, $foo, Header::headerBasic()), true);

            if (Token::saveToken($res)) {
                // create meeting.
                dump('success');
            } else {
                $ret['errorMessage'] = '';
                $ret['errorCode'] = '';
                Foo::error($ret);
            }
        } else {
            self::authorize();
        }
    }

    public function getToken(): string
    {

    }

    /**
     * Refresh token
     */
    public function refreshToken()
    {
        $data['grant_type'] = 'refresh_token';
        $data['refresh_token'] = $YOUR_REFRESH_TOKEN;
        $res = json_decode(Foo::httpsCurl($url, $data, Header::headerBasic()), true);
        Token::saveToken($res);
    }
}
