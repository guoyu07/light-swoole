<?php

namespace App\Providers;

use League\Route\Http\Exception\HttpExceptionInterface;
use League\Route\Strategy\JsonStrategy;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use App\Http\Middleware\LoggerMiddleware;
use App\Http\Middleware\HttpExceptionMiddleware;


/**
 * Class RouteServiceProvider
 * 
 * 
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class RouteServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @var array
     */
    protected $provides = [];

    /**
     * In much the same way, this method has access to the container
     * itself and can interact with it however you wish, the difference
     * is that the boot method is invoked as soon as you register
     * the service provider with the container meaning that everything
     * in this method is eagerly loaded.
     *
     * If you wish to apply inflectors or register further service providers
     * from this one, it must be from a bootable service provider like
     * this one, otherwise they will be ignored.
     */
    public function boot()
    {
        $container = $this->getContainer();
        $route = require_once APP_PATH.DS.'Http'.DS.'routes.php';
        $logger_middleware = new LoggerMiddleware;
        $route->middleware($logger_middleware);

        $response = $route->dispatch(
            $container->get('request'),
            $container->get('response')
        );
        $container->get('emitter')->emit($response);
    }

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        // maybe add somethink
    }
}
