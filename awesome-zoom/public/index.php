<?php
error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR);
define('APP_NAME', 'awesome-zoom');
define('DSE', DIRECTORY_SEPARATOR);
define('APP_ROOT', __DIR__.DSE);
define('APP_CORE', APP_ROOT.'awesome-zoom'.DSE);
define('APP_BOOTSTRAP', APP_CORE.'bootstrap'.DSE);

if (!is_file(APP_BOOTSTRAP.'app.php'))
    die('Cannot find the `bootstrap/app.php` file!');
require APP_BOOTSTRAP.'app.php';
