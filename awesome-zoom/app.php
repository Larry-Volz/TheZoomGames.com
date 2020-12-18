<?php
spl_autoload_register(function($class) {
    $filename = str_ireplace('\\', '/', __DIR__.'/app'.strpbrk($class, '\\').'.class.php');
    if (is_file($filename))
        require_once $filename;
});
require_once AWESOME_ZOOM.'funs.php';
new app\AwesomeZoom();
