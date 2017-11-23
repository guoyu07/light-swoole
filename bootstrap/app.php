<?php

$timezone = config('app.timezone', 'Asia/Shanghai');
date_default_timezone_set($timezone);

// Load Dotenv

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

// Using whoops

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Using Laravel Translator

$welcome = trans('message.welcome');
var_dump($welcome);

// Using Laravel DB and Eloquent

$driver = config('database.default', 'mysql');
$database = config('database.connections.'.$driver);
$connection = new \LightSwoole\Framework\DB();
$connection->addConnection($database);
$connection->bootEloquent();
$connection->setAsGlobal();

// Using Laravel Validation 

$validator = \LightSwoole\Framework\Validator::make(['id' => '1', 'password' => '1234', 'phone' => '11000000000'], ['id' => 'required|exists:articles,id', 'password' => 'required|min:6', 'phone' => 'cellphone']);
var_dump($validator->messages());

