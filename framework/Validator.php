<?php

namespace LightSwoole\Framework;

use Illuminate\Validation\Factory;
use Illuminate\Validation\DatabasePresenceVerifier;
use LightSwoole\Framework\DB;
use LightSwoole\Framework\Translator;

/**
 * Class Validator
 *
 * @package LightSwoole\Framework
 * @author raoyc <raoyc2009@gmaill.com>
 * @link   https://raoyc.com
 */
class Validator
{
    /**
     * Laravel Validation Factory
     * 
     * @var null|Illuminate\Validation\Factory
     */
    private static $factory = null;

    /**
     * using Laravel Validation
     *
     * See https://laravel.com/docs/5.5/validation#available-validation-rules
     *
     * @param array $data
     * @param array $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (self::$factory === null) {
            $instanace = app('translator')->getInstance();
            $factory = new Factory($instanace);
            $factory->setPresenceVerifier(new DatabasePresenceVerifier(app('db')->getDatabaseManager()));
            // Validate cellphone number in mainland China
            $factory->extend('cellphone', function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^13[0-9]{9}|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}|170[059]{1}[0-9]{8}|18[0-9]{9}|177[0-9]{8}$/', $value);
            });
            self::$factory = $factory;
        } else {
            $factory = self::$factory;
        }

        $validator = $factory->make($data, $rules);
        return $validator;
    }
}
