# LightSwoole

>   LightSwoole - experience the dual pleasure of combining Laravel with Swoole. Light-weight and design for services.

[简体中文读我](README_zh-CN.md)

## Laravel Components

### Database

>   You can see official documentation at https://laravel.com/docs/5.5/database .

You can use Laravel Database in 2 ways:

```php
use LightSwoole\Framework\DB;
DB::table('articles')->where('id', 1)->first();

// or 

container('db')->('articles')->where('id', 1)->first();
```

### Validation

>   You can see official documentation at https://laravel.com/docs/5.5/validation .

You can use Laravel Validation in 3 ways:

```php
use LightSwoole\Framework\Validator;
$validator = Validator::make([
                                'username' => 'light_swoole',
                                'password' => '1234',
                                'phone' => '11000000000'
                            ], 
                            [
                                'username' => 'required', 
                                'password' => 'required|min:6|max:20', 
                                'phone' => 'cellphone'
                            ]);
var_dump($validator->messages());

// or

$validator = validator([
                            'username' => 'light_swoole',
                            'password' => '1234',
                            'phone' => '11000000000'
                        ], 
                        [
                            'username' => 'required', 
                            'password' => 'required|min:6|max:20', 
                            'phone' => 'cellphone'
                        ]);
var_dump($validator->messages());

// or 

container('validator')->make(...);
```

### Translator

>   You can see official documentation at https://laravel.com/docs/5.5/localization .

Using Laravel Translator below: 

```php
trans('message.welcome');
trans_choice('message.apples', 10);
trans_choice('message.bananas', 12);
```

You can see localization files in `resources/lang` directory.

## Other Components

### PHP errors for cool kids (filp/whoops)

>   just see at https://github.com/filp/whoops .

### DotEnv (vlucas/phpdotenv)

>   Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically. Just see at https://github.com/vlucas/phpdotenv .

### Logger (monolog/monolog)

>   Sends your logs to files, sockets, inboxes, databases and various web services. Just see at https://github.com/Seldaek/monolog .

Usage Example:

```php
use LightSwoole\Framework\Log;
Log::info('hello world!');

// or
container('log')->info('hello world');

// or
info('hello world!');  // = Log::info('hello world');

// or
logger('just for debug!');  // = Log::debug('debug');
logger()->debug('just for debug!');  // = Log::debug('debug');
logger()->info('hello world!');  // = Log::info('hello world');
```

Normally you can see logs in `storage/logs` directory.

### Config (hassankhan/config)

>   Config is a lightweight configuration file loader that supports PHP, INI, XML, JSON, and YAML files. Just see at https://github.com/hassankhan/config .

Usage Example:

```php
config('app.timezone');
```

### Request and Response (zendframework/zend-diactoros)

>   Just see at https://github.com/zendframework/zend-diactoros .

Usage Example:

```php
request();
server();
cookie();
redirect();
response();
response_text();
response_html();
response_json();
response_empty();
```

### Route (league/route)

>   Fast router and dispatcher built on top of FastRoute. Just see at https://github.com/thephpleague/route and http://route.thephpleague.com/ .

Usage Example:

```php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$route = container('route');
$route->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    return response_html();
});
```

### Container (league/container)

>   Small but powerful dependency injection container. Just see at https://github.com/thephpleague/container and http://container.thephpleague.com/ .


## Restful API Service Example

A `restful api` service example have been offered. 
See similar documentation at [TinyMe api-service](https://github.com/ycrao/tinyme#api-service) to demonstrate it.