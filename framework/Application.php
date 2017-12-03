<?php

namespace LightSwoole\Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use LightSwoole\Framework\ {
    Container,
    DB,
    Log,
    Validator,
    Translator,
    Facades\Facade,
    Exceptions\InvalidParamException
};
use League\Route\ {
    RouteCollection,
    Http\Exception\HttpExceptionInterface
};
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class Application
 *
 * @package LightSwoole\Framework
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class Application
{

    const VERSION = '0.1.0';

    /**
     * The name for the application.
     * 
     * @var string
     */
    public $name = 'LightSwoole';


    /**
     * The root path for the application.
     *
     * @var string
     */
    public $root;

    /**
     * debug or not
     * 
     * @var boolean
     */
    public $debug = true;

    /**
     * The environment that the application is running on `local`, `testing`, `staging` or `production` .
     *
     * @var string
     */
    public $environment = 'local';

    public $providers = [];

    public $routes = [];

    public $facades = [];

    protected $bootstrapped = false;

    protected $route;

    protected $lastError;

    public $server;

    /**
     * Indicates if the class aliases have been registered.
     *
     * @var bool
     */
    protected static $aliasesRegistered = false;

    /**
     * init
     */
    public function init()
    {
        $this->container = Container::getInstance();
        $environment = env('APP_ENV', 'local');
        $this->environment = $environment;
        $this->debug = env('APP_DEBUG', true);
        return $this->bootstrap();
    }

    /**
     * getEnvironment
     * 
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * bootstrap
     */
    private function bootstrap()
    {
        if (!$this->bootstrapped) {
            try {
                $this->initializeConfig();
                $this->registerKernelServices();
                $this->addServiceProviders();
                $this->bootstrapped = true;
            } catch (HttpExceptionInterface $e) {
                $this->container->get('log')->error($e);
                $this->lastError = $e;
                throw $e;
            } catch (\Exception $e) {
                if ($this->debug == true || $this->environment === 'testing' || $this->environment === 'local') {
                    throw $e;
                }
                $this->lastError = $e;
                $this->container->get('log')->emergency($e);
            } catch (\Throwable $e) {
                if ($this->debug == true || $this->environment === 'testing' || $this->environment === 'local') {
                    throw $e;
                }
                $this->lastError = $e;
                $this->container->get('log')->emergency($e);
            }
        }
        return $this;
    }

    /**
     * initializeConfig
     * 
     * @return void
     */
    private function initializeConfig()
    {
        $timezone = config('app.timezone', 'Asia/Shanghai');

        date_default_timezone_set($timezone);
    }

    /**
     * addServiceProviders
     *
     * @return void
     */
    protected function addServiceProviders()
    {
        $providers = config('app.providers');
        if (is_array($providers)) {
            $this->providers = $providers;
            foreach ($providers as $provider) {
                $this->container->addServiceProvider($provider);
            }
        }
    }

    /**
     * bind
     * 
     * @param  string $alias
     * @param  string $service
     * @return void
     */
    public function bind($alias, $service)
    {
        $container = $this->container;
        if ($container->has($alias)) {
            throw new InvalidParamException("Can not bind service, service '$alias' is already exists.");
        }
        $container->share($alias, $service);
    }

    /**
     * registerKernelServices
     * 
     * @return array
     */
    private function registerKernelServices()
    {
        $container = $this->container;

        // Using Monolog Logger
        $container->share('log', function () {
            $logger = new Logger('light_swoole');
            $logPath = config('app.logger_path');
            $logFile = (!empty($logPath)) ? rtrim($logPath, '/').'/'.date('Ymd').'.log' : __DIR__ . '/../log/'.date('Ymd').'.log';
            $logger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
            return $logger;
        });

        // Using Laravel DB and Eloquent
        $container->share('db', function () {
            $driver = config('database.default', 'mysql');
            $database = config('database.connections.'.$driver);
            $connection = new DB();
            $connection->addConnection($database);
            $connection->bootEloquent();
            $connection->setAsGlobal();
            return $connection;
        });

        // Using Laravel Translator
        $container->share('translator', Translator::class);

        // Using Laravel Validator
        $container->share('validator', Validator::class);

        // Using zendframework/zend-diactoros Request
        $container->share('request', function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        // Using zendframework/zend-diactoros Response
        $container->share('response', Response::class);

        $container->share('emitter', SapiEmitter::class);

        // Using League Route
        $container->share('route', new RouteCollection($container));
    }

    /**
     * Register the facades for the application.
     *
     * @param  bool  $aliases
     * @param  array $userAliases
     * @return void
     */
    public function withFacades($aliases = true)
    {
        Facade::setFacadeApplication($this);

        if ($aliases) {
            $this->withAliases();
        }
    }

    /**
     * Register the aliases for the application.
     *
     * @param  array  $userAliases
     * @return void
     */
    public function withAliases()
    {
        if (! static::$aliasesRegistered) {
            static::$aliasesRegistered = true;
            $aliases = config('app.aliases');
            if (is_array($aliases)) {
                foreach ($aliases as $alias => $original) {
                    class_alias($original, $alias);
                }
            }
        }
    }

    /**
     * __get
     * 
     * @param  string $alias
     * @return object
     */
    public function __get($alias)
    {
        if (isset($this->$alias)) {
            return $this->$alias;
        } elseif ($this->container->has($alias)) {
            return $this->services[$alias] = $this->container->get($alias);
        }
    }
}