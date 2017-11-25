<?php

namespace LightSwoole\Framework;

/**
 * Class Log
 * 
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class Log
{

    protected static $type = ['debug', 'info', 'notice', 'warnnig', 'err', 'error', 'crit', 'critical', 'alert', 'emerg', 'emergency'];

    public function __construct()
    {

    }

    private static function write($type = 'log', string $message, array $data = [])
    {
        return app('log')->$type($message, $data);
    }


    public static function __callStatic($method, $args)
    {
        var_dump($method, $args);
        if (in_array($method, self::$type)) {
            if (!is_array($args)) {
                $args = [$args];
            }
            array_unshift($args, $method);
            return call_user_func_array('\\LightSwoole\\Framework\\Log::write', $args);
        }
    }


}