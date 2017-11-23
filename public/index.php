<?php

/**
 * Light Swoole Framework For Web Artisans !
 *
 * @package  Light Swoole
 */


require __DIR__.'/../bootstrap/autoload.php';

require_once __DIR__.'/../bootstrap/app.php';

$article = \LightSwoole\Framework\DB::table('articles')->where('id', 1)->first();
var_dump($article);

