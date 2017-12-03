<?php

use Noodlehaus\Config;
use LightSwoole\Framework\ {
    Container,
    Translator,
    Request,
    Exceptions\InvalidParamException
};
use Zend\Diactoros\Response\ {
    RedirectResponse,
    TextResponse,
    HtmlResponse,
    JsonResponse,
    EmptyResponse
};
use League\Container\Argument\RawArgument;
use League\Route\Strategy\JsonStrategy;

if (! function_exists('config')) {

    /**
     * Get the specified configuration value.
     *
     * @param  null|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return null;
        }
        $paths = explode('.', $key);
        $count = count($paths);
        if ($count < 2) {
            return null;
        } else {
            $conf = Config::load(CONFIG_PATH.DS.$paths[0].'.php');
            $new_key = mb_substr($key, mb_strlen($paths[0]) + 1);
            return $conf->get($new_key, $default);
        }
    }
}

if (! function_exists('container')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $alias
     * @return mixed
     */
    function container($alias = null)
    {
        $container = Container::getInstance();
        if (is_null($alias)) {
            return $container;
        } elseif ($container->has($alias)) {
            return $container->get($alias);
        } else {
            $container->add($alias);
            return $container->get($alias);
        }
        throw new InvalidParamException('invalid Container alias name!');
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $alias
     * @return mixed
     */
    function app()
    {
        return container('app');
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $locale
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    function trans($id = null, $parameters = [], $locale = null)
    {
        return container('translator')->trans($id, $parameters, $locale);
    }
}

if (! function_exists('trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $id
     * @param  int|array|\Countable  $number
     * @param  array   $parameters
     * @param  string  $locale
     * @return string
     */
    function trans_choice($id, $number, array $parameters = [], $locale = null)
    {
        return container('translator')->transChoice($id, $number, $parameters, $locale);
    }
}

if (! function_exists('info')) {
    /**
     * Write some information to the log.
     *
     * @param  string  $message
     * @param  array   $context
     * @return void
     */
    function info($message, $context = [])
    {
        return container('log')->info($message, $context);
    }
}

if (! function_exists('logger')) {
    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return \Illuminate\Contracts\Logging\Log|null
     */
    function logger($message = null, array $context = [])
    {
        if (is_null($message)) {
            return container('log');
        }

        return container('log')->debug($message, $context);
    }
}

if (! function_exists('validator')) {
    /**
     * Create a new Validator instance.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $factory = container('validator');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}

if (! function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null  $to
     * @param  int     $status
     * @param  array   $headers
     * @return end\Diactoros\Response\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = [])
    {
        return new RedirectResponse($to, $status, $headers);
    }
}

if (! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  string  $key  get.pid post.pid
     * @param  mixed   $default 
     * @return mixed
     */
    function request($key = null, $default = null)
    {
        return Request::input($key, $default);
    }
}

if (! function_exists('server')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  string  $key  get.pid post.pid
     * @param  mixed   $default 
     * @return mixed
     */
    function server($key = null, $default = null)
    {
        return Request::server($key, $default);
    }
}

if (! function_exists('cookie')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  string  $key  get.pid post.pid
     * @param  mixed   $default 
     * @return mixed
     */
    function cookie($key = null, $default = null)
    {
        return Request::cookie($key, $default);
    }
}

if (! function_exists('response')) {
    /**
     * Return a new response from the application. 
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return 
     */
    function response($content = null, $status = 200, array $headers = [])
    {
        $response = container('response');
        if (is_null($content)) {
            return $response;
        }

        $response->getBody()
                 ->write($content);
        $response->withStatus($status)
                ->withHeader('Content-Type', 'text/plain');
        return $response;
    }
}

if (! function_exists('response_text')) {
    /**
     * Return a new text response from the application.
     *
     * @param  string  $text
     * @param  int     $status
     * @param  array   $headers
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    function response_text($text = 'Light Swoole!', $status = 200, array $headers = [])
    {
        return new TextResponse($text, $status, $headers);
    }
}

if (! function_exists('response_html')) {
    /**
     * Return a new html response from the application.
     *
     * @param  string  $html
     * @param  int     $status
     * @param  array   $headers
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    function response_html($html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Hello World!</title>
</head><body style="font-family:\'Courier New\', Courier, monospace; text-align: center;"><h1>Hello World!<h1><p style="font-size:14px;">powered by <a href="https://github.com/qianchang-network/light-swoole" style="color: #333;">light-swoole</a></p></body></html>', $status = 200, array $headers = [])
    {
        return new HtmlResponse($html, $status, $headers);
    }
}

if (! function_exists('response_json')) {
    /**
     * Return a new json response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return Zend\Diactoros\Response\JsonResponse
     */
    function response_json($data = '', $status = 200, array $headers = [], $encodingOptions = JsonResponse::DEFAULT_JSON_FLAGS)
    {
        return new JsonResponse($data, $status = 200, $headers, $encodingOptions);
    }
}

if (! function_exists('response_empty')) {
    /**
     * Return a new json response from the application.
     *
     * @param  int     $status
     * @param  array   $headers
     * @return Zend\Diactoros\Response\EmptyResponse
     */
    function response_empty($status = 204, array $headers = [])
    {
        return new EmptyResponse($status = 204, $headers);
    }
}

if (! function_exists('abort')) {
    /**
     * Return a new json response from the application.
     *
     * @param  int     $status
     * @param  array   $headers
     * @return Zend\Diactoros\Response\EmptyResponse
     */
    function abort($status = 404, $msg = null, array $headers = [])
    {
        if (is_null($msg)) {
            switch ($status) {
                case '401':
                    $msg = 'Unauthorized!';
                    break;
                case '403':
                    $msg = 'Forbidden!';
                    break;
                case '404':
                    $msg = 'Not Found!';
                    break;
                default:
                    $msg = 'Internal Server Error!';
                    break;
            }
        }

        // if Global JsonStrategy
        $strategy = container('route')->getStrategy();
        if ($strategy instanceof JsonStrategy) {
            return response_json([
                        'status_code' => $status,
                        'message'     => $msg,
                    ], $status, $headers);
        }
        /*
        $tplt = [
                    '<!DOCTYPE html>',
                    '<html lang="en">',
                    '<head>',
                    '<meta charset="UTF-8">',
                    '<title>[:title:]</title>',
                    '</head>',
                    '<body style="font-family:\'Courier New\', Courier, monospace; text-align: center;">',
                    '<h1>[:title:]<h1>',
                    '</body>',
                    '</html>'
                ];

        $html = implode('', $tplt);
        $html = str_replace('[:title:]', $msg, $html);
        return response_html($html, $status, $headers);
        */
        return response_text($msg, $status, $headers);
    }
}


if (!function_exists('url')) {

    /**
     * Generate RESTFUL URL
     * 
     * url('admin:res.index') === '//example.com/admin/res'
     * url('admin:res.create') === '//example.com/admin/res/create'
     * url('admin:res.create', [ 'lang' =>'chs' ]) === '//example.com/admin/res/create?lang=chs'
     * url('admin:res.store') === '//example.com/admin/res'
     * url('admin:res.show') === '//example.com/admin/res/{id}'
     * url('admin:res.edit') === '//example.com/admin/res/{id}/edit'
     * url('admin:res.edit', 5) === '//example.com/admin/res/5/edit'
     * url('admin:res.edit', [5, 'lang' => 'chs']) === '//example.com/admin/res/5/edit?lang=chs'
     * url('admin:res.update') === '//example.com/admin/res/{id}'
     * url('admin:res.destroy') === '//example.com/admin/res/{id}'
     * url('admin:user.photo') === '//example.com/admin/user/photo'
     * url('admin:user.{id}.block', 5) === '//example.com/admin/user/5/block
     * url('admin:user.{uid}.photo.{pid}', [4, 5, 'lang' => 'chs']);  //等价于 '//example.com/admin/user/4/photo/5?lang=chs'
     *
     * @param string $name
     * @param int|string|array $parameters
     * @param bool $withDomain
     * @return string
     */
    function url($name, $parameters = [], $withDomain = true)
    {
        if ($withDomain) {
            // 
            $host = isset(container('request')->getServerParams()['HTTP_HOST']) ? container('request')->getServerParams()['HTTP_HOST'] : '';
            $host = empty($host) ? '/' : '//'.$host;
        } else {
            $host = '';
        }
        $segments = explode(':', $name);
        if (count($segments) != 2) {
            throw new \Exception("{$name} - Invalid url path!");
        } else {
            $_prefix = $segments[0];
            $_query = '';
            $_ids = [];
            $path = explode('.', $segments[1]);
            $last = last($path);
            array_pop($path);
            $_path = implode('/', $path);
            switch ($last) {
                case 'index':
                case 'store':
                    break;
                case 'create':
                    $_path .= '/create';
                    break;
                case 'show':
                case 'update':
                case 'destroy':
                    $_path .= '/{id}';
                    break;
                case 'edit':
                    $_path .= '/{id}/edit';
                    break;
                default:
                    $_path .= '/'.$last;
                    break;
            }
            $parameters = is_array($parameters) ? $parameters : [$parameters];
            if (count($parameters) !== 0) {
                $_query = http_build_query(
                    $params = array_where($parameters, function($key, $value) {
                        return is_string($key);
                    })
                );
                $ids = array_where($parameters, function($key, $value) {
                        return is_int($key);
                    }
                );
                $_ids = $ids;
            }
            preg_match_all('/\{(\w+?)\}/', $_path, $matches);
            array_map(function($m, $r) use (&$_path) {
                    if(isset($r)) {
                        $_path = str_replace($m, $r, $_path);
                    }
            }, $matches[0], $_ids);
            $_site_url = $host.'/'.$_prefix.'/'.$_path;
            $_url = empty($_query) ? $_site_url : $_site_url.'?'.trim($_query, '&');
            return $_url;
        }
    }

}