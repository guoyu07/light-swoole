<?php


// Using whoops

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


// Using monolog

LightSwoole\Framework\Log::info('hello world', ['hello', 'world']);

// Load Dotenv

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

// Using Laravel DB and Eloquent
$driver = config('database.default', 'mysql');
$database = config('database.connections.'.$driver);
$connection = new \LightSwoole\Framework\DB();
$connection->addConnection($database);
$connection->bootEloquent();
$connection->setAsGlobal();

// Using Laravel Validation 


/*
$filesystem = new \Illuminate\Filesystem\Filesystem();
$fileLoader = new \Illuminate\Translation\FileLoader($filesystem, APP_PATH.'/config');
$translator = new \Illuminate\Translation\Translator($fileLoader, 'extra');
$factory = new \Illuminate\Validation\Factory($translator);
$factory->setPresenceVerifier(new DatabasePresenceVerifier($connection->getDatabaseManager()));

$factory->extend('cellphone', function ($attribute, $value, $parameters, $validator) {
    return preg_match('/^13[0-9]{9}|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}|170[059]{1}[0-9]{8}|18[0-9]{9}|177[0-9]{8}$/', $value);
});


$messages = config('validation')['custom'];
$validator = $factory->make($data, $rules, $messages);

return $validator;
*/