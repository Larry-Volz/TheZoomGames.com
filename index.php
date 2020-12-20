<?php
$phpversion = '5.4.0';
if(version_compare(PHP_VERSION,$phpversion,'<')) die("require PHP > $phpversion !");
define('DSE', DIRECTORY_SEPARATOR);
define('APP_DEBUG',true);
$dse = DSE;

if (isset($_REQUEST['FIRST_FOLDER']) && $_REQUEST['FIRST_FOLDER'])
    $folder = $_REQUEST['FIRST_FOLDER'];
else
    $folder = "zoom";

$path = ".${dse}${folder}${dse}";
define('APP_PATH',$path);
define('APP_NAME','app_name');
define('_PHP_FILE_',$_SERVER['SCRIPT_NAME']);

require 'zoom/ThinkPHP/ThinkPHP.php';