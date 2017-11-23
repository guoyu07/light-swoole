<?php

namespace LightSwoole\Framework;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{

    protected static $type = ['debug', 'info', 'notice', 'warnnig', 'err', 'error', 'crit', 'critical', 'alert', 'emerg', 'emergency'];

    public function __construct()
    {

    }

    private static function write($type = 'log', string $message, array $data = [])
    {
        $logger = new Logger('light_swoole');
        $logPath = config('app.logger_path');
        $logFile = (!empty($logPath)) ? rtrim($logPath, '/').'/'.date('Ymd').'.log' : __DIR__ . '/../log/'.date('Ymd').'.log';
        $logger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        return $logger->$type($message, $data);
    }

    public static function __callStatic($method, $args)
    {
        if (in_array($method, self::$type)) {
            if (!is_array($args)) {
                $args = [$args];
            }
            array_unshift($args, $method);
            return call_user_func_array('\\LightSwoole\\Framework\\Log::write', $args);
        }
    }

}