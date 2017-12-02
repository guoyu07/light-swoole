# LightSwoole

>   LightSwoole - 体验 `Laravel` 与 `Swoole` 结合的 双重快感，轻型专为服务而生。

[English README](README.md)

## Laravel 组件依赖

### Database

>   您可以从官方网站  https://laravel.com/docs/5.5/database 获取帮助文档。

使用 `Laravel Database` 2 种示例方法：

```php
use LightSwoole\Framework\DB;
DB::table('articles')->where('id', 1)->first();

// or 

container('db')->('articles')->where('id', 1)->first();
```

### Validation

>   您可以从官方网站 https://laravel.com/docs/5.5/validation 获取帮助文档。

使用 `Laravel Validation` 3 种示例方法:

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

>   您可以从官方网站 https://laravel.com/docs/5.5/localization 获取帮助文档。

参考示例使用 `Laravel Translator` ： 

```php
trans('message.welcome');
trans_choice('message.apples', 10);
trans_choice('message.bananas', 12);
```

您可以在 `resources/lang` 目录找到本地化配置文件。

## 其他组件

### PHP 抛错 (filp/whoops)

>   参考 https://github.com/filp/whoops .

### DotEnv (vlucas/phpdotenv)

>   自动化从 `env` 文件加载环境变量，参考 https://github.com/vlucas/phpdotenv 。

### 日志 (monolog/monolog)

>   发送您的日志到多种服务（如 文件、 套接字、数据库等），参考 https://github.com/Seldaek/monolog 。

使用示例：

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

通常您可以在 `storage/logs` 目录看到日志文件。

### 配置 (hassankhan/config)

>   轻型的配置文件加载器，支持多种文件格式（如 `PHP`、 `INI`、`XML`、 `JSON`、 以及 `YAML` 等）， 参考 https://github.com/hassankhan/config 。

使用示例：

```php
config('app.timezone');
```

### 请求与相应 (zendframework/zend-diactoros)

>   参考 https://github.com/zendframework/zend-diactoros 。

使用示例：

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

### 路由 (league/route)

>   基于 FastRoute 构建的快速路由分发器，参考 https://github.com/thephpleague/route 和 http://route.thephpleague.com/ 。

使用示例：

```php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$route = container('route');
$route->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    return response_html();
});
```

### 容器 (league/container)

>   轻型依赖注入容器，参考 https://github.com/thephpleague/container 和 http://container.thephpleague.com/ .


## Restful API 服务示例

我们提供一个 `restful api` 服务示例，参考同类文档 
[TinyMe api 服务](https://github.com/ycrao/tinyme/blob/master/README_zh-CN.md#api-服务) 去演练它。


