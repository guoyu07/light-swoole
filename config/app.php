<?php

return [

    'env' => env('APP_ENV', 'production'),

    'debug' => env('APP_DEBUG', false),

    'timezone' => env('APP_TIMEZONE', 'Asia/Shanghai'),

    'key' => env('APP_KEY'),

    'locale' => 'zh-CN',

    'fallback_locale' => 'en',

    'logger_path' => BASE_PATH.DS.'storage'.DS.'logs',


];
