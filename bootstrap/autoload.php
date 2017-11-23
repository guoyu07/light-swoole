<?php

define('LIGHT_SWOOLE_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';


define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', BASE_PATH.DS.'app');
define('CONFIG_PATH', BASE_PATH.DS.'config');