<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Strategy\JsonStrategy;

$route = container('route');
// $route->setStrategy(new JsonStrategy);

$route->get('/', function (ServerRequestInterface $request, ResponseInterface $response) {
    return response('Hello LightSwoole !');
});

$route->group('service', function ($route) {
    $ns = 'App\\Http\\Controllers\\Service\\';
    $route->get('identity-card', $ns.'IdentityCardController::index');
});

return $route;