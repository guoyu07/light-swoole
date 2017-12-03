<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LoggerMiddleware
 * 
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class LoggerMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $middlewares = container('route')->getMiddlewareStack();


        $response = $next($request, $response);

        logger('Request/Response', [
            'middlewares' => $middlewares,
            'request' => \Zend\Diactoros\Request\ArraySerializer::toArray($request),
            'response' => \Zend\Diactoros\Response\ArraySerializer::toArray($response),
        ]);

        return $response;
    }
}