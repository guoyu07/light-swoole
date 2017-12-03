<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Http\Exception\HttpExceptionInterface;

/**
 * Class HttpExceptionMiddleware
 * 
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class HttpExceptionMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            $response = $next($request, $response);
        } catch (HttpExceptionInterface $e) {
            $response->getBody()->write($e->getMessage());
            $response->withStatus($e->getStatusCode());
        }
        return $response;
    }
}