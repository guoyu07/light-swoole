<?php

// Load Dotenv

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

// Using whoops

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$app = new LightSwoole\Framework\Application();
$app->init();

require_once APP_PATH.DS.'Http'.DS.'route.php';

return $app;
