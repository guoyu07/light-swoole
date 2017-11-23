<?php

namespace LightSwoole\Framework;


class Validator
{
    static $factory = null;

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

            $filesystem = new \Illuminate\Filesystem\Filesystem();
            $fileLoader = new \Illuminate\Translation\FileLoader($filesystem, APP_PATH.'/config');
            $translator = new \Illuminate\Translation\Translator($fileLoader, 'extra');
            $factory = new \Illuminate\Validation\Factory($translator);

            $database = [
                'driver'    => 'mysql',
                'host'      => env('DB_HOST', '114.215.133.153'),
                'database'  => env('DB_NAME', 'ultron'),
                'username'  => env('DB_USER', 'root'),
                'password'  => env('DB_PASS', '123456'),
                'port'      => env('DB_PORT', '65501'),
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ];
            $connection = new DB();
            $connection->addConnection($database);
            $connection->bootEloquent();
            $connection->setAsGlobal();
            $factory->setPresenceVerifier(new Illuminate\Validation\DatabasePresenceVerifier($connection->getDatabaseManager()));

            // Validate cellphone number in mainland China
            $factory->extend('cellphone', function ($attribute, $value, $parameters, $validator) {
                return preg_match('/^13[0-9]{9}|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}|170[059]{1}[0-9]{8}|18[0-9]{9}|177[0-9]{8}$/', $value);
            });

            self::$factory = $factory;

        } else {

            $factory = self::$factory;

        }

        $messages = config('validation')['custom'];
        $validator = $factory->make($data, $rules, $messages);
        return $validator;
    }
}
