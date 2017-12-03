<?php

// Load Dotenv

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

// Using whoops

$whoops = new \Whoops\Run;
if (env('APP_DEBUG')) {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(new \LightSwoole\Framework\JsonWhoopsHandler);
}
$whoops->register();


$container = container();
$container->share('app', LightSwoole\Framework\Application::class);
$app = $container->get('app')->init();
// $app->withFacades(true);
return $app;
