<?php
function dump($bar)
{
    ob_start();
    echo('<pre>');
    print_r($bar);
    echo('</pre>');
    echo ob_get_clean();
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