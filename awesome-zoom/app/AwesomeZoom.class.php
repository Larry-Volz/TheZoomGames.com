<?php
namespace app;
use \form\Validation;

class AwesomeZoom
{
    const API_KEY = 'PQzQIKdbRjuhJu3w9XQS2g';
    const API_SECRET = 'tQpPwgiFchDJ3R5Koelaw3IqqQNDP8wir5Kf';
    const CLIENT_ID = 'kywQ5vr3TUGbokq9LXcIyA';
    const CLIENT_SECRET = 'GC1OqzVfuYq8fJ6rv2X9dfIuXjVbSYOO';

    const OAUTH_AUTHORIZE = 'https://zoom.us/oauth/authorize';
    const OAUTH_ACCESSTOKEN = 'https://zoom.us/oauth/authorize';
    const DENY_METHODS = ['__construct', 'run'];
    const ERRORS = [
        5001 => 'Unknow error!',
        5050 => 'Fatal error!',
        5051 => 'Invalid operation!',
    ];
    private $error = null;
    private $pinfo = '';

    public function __construct() {
        self::run();
    }

    // die dump.
    private function dd($bar)
    {
        ob_start();
        echo('<pre>');
        var_dump($bar);
        echo('</pre>');
        die(ob_get_clean());
    }

    /**
     * run.
     * maybe should just put those code into __construct().
     */
    public function run()
    {
        // if no _SERVER['PATH_INFO']
        if (!isset($_SERVER['PATH_INFO']))
            die(header('Location:index.html'));

        // path info -> method name.
        $this->pinfo = current(explode('/', ltrim($_SERVER['PATH_INFO'], '/')));

        // check if in dead loop method list.
        if (in_array($this->pinfo, self::DENY_METHODS))
            self::fail(5050);

        // check method exists and call the method.
        $pinfo = $this->pinfo;
        if (method_exists($this, $pinfo))
            return self::$pinfo();
        else
            self::fail(5051);
    }

    /**
     * call self::generateSignature().
     */
    public function signature()
    {
        if (Validation::validate([
            'meetingNumber' => ['require', 'integer'],
            'role' => ['require', ['in', [0, 1]]]
        ])) {
            $arr['apiKey'] = self::API_KEY;
            $arr['signature'] = GenerateSignature::generateSignature(
                self::API_KEY,
                self::API_SECRET,
                $_POST['meetingNumber'],
                $_POST['role']
            );
            JsonResponse::json($arr);
        } else {
            self::fail('from validation fail');
        }
    }

    /**
     * $foo: errorCode || errorMessage
     */
    private function fail($foo=null)
    {
        $ecode = key(self::ERRORS);
        $emsg = current(self::ERRORS);
        if ($foo !== null)
        {
            if (self::ERRORS[$foo])
            {
                $emsg = self::ERRORS[$foo];
                $ecode = $foo;
            } else {
                $emsg = $foo;
            }
        } else
            if ($this->error !== null)
                $emsg = $this->error;

        $arr['errorCode'] = $ecode;
        $arr['errorMessage'] = $emsg;
        $arr['method'] = $this->pinfo;
        $arr['result'] = $emsg;
        $arr['status'] = $ecode < 300;
        JsonResponse::error($arr);
    }

    /**
     * Request User Authorization.
     */
    public function userAuth()
    {
        $arr[] = 'response_type=code';
        $arr[] = 'redirect_uri=https://02fa5d6d5265.ngrok.io/accessToken';
        $arr[] = 'client_id='.self::CLIENT_ID;
        JsonResponse::json([
            'url' => 'https://zoom.us/oauth/authorize?' . implode('&', $arr)
        ]);
    }

    public function receive()
    {
        var_dump($_REQUEST);
    }

    /**
     * Request Access Token.
     */
    public function accessToken()
    {
        if (Validation::validate(['code' => ['require', 33]]))
        {
            $data['grant_type'] = 'authorization_code';
            $data['code'] = $_GET['code'];
            $data['redirect_uri'] = 'https://02fa5d6d5265.ngrok.io/receive';
            foreach ($data as $key => $value)
                $arr[] = "$key=$value";

            $url = 'https://zoom.us/oauth/token';//.implode('&', $arr);
            $bar = base64_encode(self::CLIENT_ID.':'.self::CLIENT_SECRET);
            $header[] = "Authorization: Basic $bar";
            $res = self::curl($url,$data,$header,$a=1);
            if ($res)
            {
                var_dump($res);
            } else {
                $ret['url'] = $url;
                $ret['data'] = $data;
                $ret['header'] = $header;
                JsonResponse::json($ret);
            }
        }
    }

    private function curl($url=null, $data=null, $header=null)
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_POSTFIELDS => $data
            // CURLOPT_HTTPHEADER => array(
            //     "authorization: Bearer JWT",
            //     "content-type: application/json"
            // ),
        ));
        $output=curl_exec($ch);
        curl_close($ch);
        return $output;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output=curl_exec($ch);
        curl_close($ch);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // if ($data !== null)
        // {
        //     curl_setopt($ch, CURLOPT_POST, true);
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // }
        // $output = curl_exec($ch);
        // curl_close($ch);
        return $output;
    }

    public function curlddddd($url,$post_data,&$header=null,&$http_status)
    {
        $ch=curl_init();
        // user credencial
        curl_setopt($ch, CURLOPT_USERPWD, "username:passwd");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        // post_data
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        if (!is_null($header))
            curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        $body = null;
        // error
        if (!$response) {
            $body = curl_error($ch);
            // HostNotFound, No route to Host, etc  Network related error
            $http_status = -1;
        } else {
           //parsing http status code
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (!is_null($header)) {
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

                $header = substr($response, 0, $header_size);
                $body = substr($response, $header_size);
            } else {
                $body = $response;
            }
        }

        curl_close($ch);

        return $body;
    }
}
