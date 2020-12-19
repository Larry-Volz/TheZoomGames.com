<?php
// bootstrap
defined('EXT') or define('EXT', '.class.php');
defined('CORE_APP') or define('CORE_APP', APP_CORE.'app'.DSE);
defined('CORE_BOOTSTRAP') or define('CORE_BOOTSTRAP', APP_CORE.'bootstrap'.DSE);
defined('CORE_CONFIG') or define('CORE_CONFIG', APP_CORE.'config'.DSE);
defined('CORE_DATABASE') or define('CORE_DATABASE', APP_CORE.'database'.DSE);
defined('CORE_PUBLIC') or define('CORE_PUBLIC', APP_CORE.'public'.DSE);
defined('CORE_RESOURCES') or define('CORE_RESOURCES', APP_CORE.'resources'.DSE);
require_once CORE_APP.'core.php';
app\core::run();
