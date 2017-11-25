# LightSwoole

>   Light Swoole Framework For Web Artisans (Laravel Style) !


## Laravel Components

### Database

>   You can see official documentation at https://laravel.com/docs/5.5/database .

You can use Laravel Database in 2 ways:

```php
use LightSwoole\Framework\DB;
DB::table('articles')->where('id', 1)->first();

// or 

app('db')->('articles')->where('id', 1)->first();
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

app('validator')->make(...);
```

### Translator

>   You can see official documentation at https://laravel.com/docs/5.5/localization .

You can use Laravel Translator 

```php
trans('message.welcome');
trans_choice('message.apples', 10);
trans_choice('message.bananas', 12);
```

You can see localization files in `resources/lang` directory.

## Other Components

### PHP errors for cool kids (filp/whoops)

>   You can see official documentation at https://github.com/filp/whoops .

### DotEnv (vlucas/phpdotenv)

>   You can see official documentation at https://github.com/vlucas/phpdotenv .

### Logger (monolog/monolog)

>   You can see official documentation at https://github.com/Seldaek/monolog .

```php
use LightSwoole\Framework\Log;
Log::info('hello world!');

// or
app('log')->info('hello world');

// or
info('hello world');  // = Log::info('hello world');

// or
logger('debug');  // = Log::debug('debug');
```

You can see logs in `storage/logs` directory.

### Config (hassankhan/config)

>   You can see official documentation at https://github.com/hassankhan/config .

```php
config('app.timezone');
```

### Request and Response (zendframework/zend-diactoros)

>   You can see official documentation at https://github.com/zendframework/zend-diactoros .

### Route (league/route)

>   You can see official documentation at https://github.com/thephpleague/route and http://route.thephpleague.com/ .

### Container (league/container)

>   You can see official documentation at https://github.com/thephpleague/container and http://container.thephpleague.com/ .

