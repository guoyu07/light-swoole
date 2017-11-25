<?php

namespace LightSwoole\Framework;

/**
 * Class Log
 *
 * @package LightSwoole\Framework
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class Log
{
    /**
     * Log level types
     * 
     * @var array
     */
    protected static $type = ['debug', 'info', 'notice', 'warnnig', 'err', 'error', 'crit', 'critical', 'alert', 'emerg', 'emergency'];

    /**
     * Write log
     * 
     * @param  string $type level
     * @param  mixed $message 
     * @param  array  $data
     * @return void
     */
    private static function write($type = 'log', $message, array $data = [])
    {
        return app('log')->$type($message, $data);
    }

    /**
     * __callStatic
     * 
     * @param  string $method
     * @param  array $args   [description]
     * @return void
     */
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