<?php
namespace app\services;

class Foo
{
    static public function json($data=[])
    {
        header_remove();
        header('Content-type: Application/json');
        die(json_encode($data));
    }

    static public function error($data=[])
    {
        $protocol = 'HTTP/1.0';
        if (isset($_SERVER['SERVER_PROTOCOL']))
            $protocol = $_SERVER['SERVER_PROTOCOL'];
        header("$protocol ${data['errorCode']} ${data['errorMessage']}");
        http_response_code($data['errorCode']);
        header("Status: ${data['errorMessage']}");
        die(self::json($data));
    }

    /**
     * generate signature function from zoom documentation.
     */
    static public function generateSignature($api_key,$api_secret,$meeting_number,$role)
    {
        $time = time() * 1000 - 30000;//time in milliseconds (or close enough)
        $data = base64_encode($api_key . $meeting_number . $time . $role);
        $hash = hash_hmac('sha256', $data, $api_secret, true);
        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }

    static public function root()
    {
        $pckey = 0;
        $protocol[0] = 'http://';
        $protocol[1] = 'https://';
        $checkpoint[] = 'SERVER_PROTOCOL';
        $checkpoint[] = 'HTTP_X_FORWARDED_PROTO';

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'))
            $pckey = 1;

        foreach ($checkpoint as $point)
        {
            if ($pckey === 1)
                continue;
            if (isset($_SERVER[$point]))
                switch ($point) {
                    default:
                        if (stripos($_SERVER[$point], 'https') === 0)
                            $pckey = 1;
                        break;
                }
        }

        return $protocol[$pckey].$_SERVER['HTTP_HOST'].'/';
    }

    static public function httpsCurl($url, $data=null, $header=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($_COOKIE['PHPSESSID']) && $foo = $_COOKIE['PHPSESSID'])
            curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=$foo");

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        session_write_close();
        $output = curl_exec($ch);
        // session_start();
        curl_close($ch);
        return $output;
    }

    static public function getUrl(string $url='', string $bar=''): string
    {
        $rule = '/\{\w*\}/';
        return preg_replace($rule, $bar, $url);
    }

    static public function build_post_fields( $data,$existingKeys='',&$returnArray=[]) {
        if(($data instanceof CURLFile) or !(is_array($data) or is_object($data))){
            $returnArray[$existingKeys]=$data;
            return $returnArray;
        }
        else{
            foreach ($data as $key => $item) {
                self::build_post_fields($item,$existingKeys?$existingKeys."[$key]":$key,$returnArray);
            }
            return $returnArray;
        }
    }
}
