<?php

namespace LightSwoole\Framework;

use Illuminate\Validation\Factory;
use Illuminate\Validation\DatabasePresenceVerifier;
use LightSwoole\Framework\DB;
use LightSwoole\Framework\Translator;


class Validator
{
    private static $factory = null;

    /**
     * using Laravel Validation
     *
     * See https://laravel.com/docs/5.4/validation#available-validation-rules
     *
     * @param array $data
     * @param array $rules
     * @return \Illuminate\Validation\Factory
     */
    public static function make($data, $rules)
    {
        if (self::$factory === null) {
            $translator = new Translator();
            $instanace = $translator->getInstance();
            $factory = new Factory($instanace);

            $driver = config('database.default', 'mysql');
            $database = config('database.connections.'.$driver);
            $connection = new DB();
            $connection->addConnection($database);
            $connection->bootEloquent();
            $connection->setAsGlobal();
            $factory->setPresenceVerifier(new DatabasePresenceVerifier($connection->getDatabaseManager()));

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
