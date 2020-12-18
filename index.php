<?php
error_reporting(E_ERROR | E_PARSE);
define('AWESOME_ZOOM', './awesome-zoom/');
if (!is_file('./awesome-zoom/app.php'))
    die('missing file!');
require './awesome-zoom/app.php';

// require '../vendor/autoload.php';
// var_dump(env());
// $zoom = new \MinaWilliam\Zoom\Zoom();
