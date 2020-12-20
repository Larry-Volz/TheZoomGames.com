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

    public function getUser() {
        $user = new User();
        $user->getUser();
    }

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
    public function getToken() {
        OAuth::getToken();
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
        // $ret['pwd'] = 'app\http\controllers\index::test()';
        $db = new \PDO("mysql:host=localhost;dbname=awesome_zoom;", 'root', '123123', [\PDO::ATTR_PERSISTENT => true]);
        $res = $db->query('select * from user;');
        $sql = 'select * from user;';
        foreach ($db->query($sql) as $num => $row)
            foreach ($row as $key => $value)
                if (!is_numeric($key))
                    $ret[$num][$key] = $value;
        dump($ret);
        exit;
        $res = $db->query('select * from awesome_zoom.user;');
        // dump($res);
        foreach ($res as $row) {
            dump($row);
        }
        // JsonResponse::json($ret);
    }
}