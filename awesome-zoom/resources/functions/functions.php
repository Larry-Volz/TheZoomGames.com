<?php
function dump($var, $echo=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

function dd($bar)
{
    die(dump($bar));
}

function root()
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

function httpsCurl($url, $data=null, $header=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $_COOKIE['PHPSESSID']);

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