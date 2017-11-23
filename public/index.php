<?php

/**
 * Light Swoole Framework For Web Artisans !
 *
 * @package  Light Swoole
 */


require __DIR__.'/../bootstrap/autoload.php';

require_once __DIR__.'/../bootstrap/app.php';

$articles = \LightSwoole\Framework\DB::table('articles')->get();

var_dump($articles);

