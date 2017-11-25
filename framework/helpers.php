<?php

use Noodlehaus\Config;
use LightSwoole\Framework\ {
    Container,
    Translator,
    Exceptions\InvalidParamException
};

if (! function_exists('config')) {

    /**
     * Get the specified configuration value.
     *
     * @param  null|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return null;
        }
        $paths = explode('.', $key);
        if (count($paths) < 2) {
            return null;
        } else {
            $conf = Config::load(CONFIG_PATH.DS.$paths[0].'.php');
            $new_key = ltrim($key, $paths[0].'.');
            return $conf->get($new_key, $default);
        }
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return mixed|\Illuminate\Foundation\Application
     */
    function app($alias = null)
    {
        $app = Container::getInstance();
        if (is_null($alias)) {
            return $app;
        } elseif ($app->has($alias)) {
            return $app->get($alias);
        }
        throw new InvalidParamException('invalid Container alias name!');
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $locale
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    function trans($id = null, $parameters = [], $locale = null)
    {
        return app('translator')->trans($id, $parameters, $locale);
    }
}

if (! function_exists('trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $id
     * @param  int|array|\Countable  $number
     * @param  array   $parameters
     * @param  string  $locale
     * @return string
     */
    function trans_choice($id, $number, array $parameters = [], $locale = null)
    {
        return app('translator')->transChoice($id, $number, $parameters, $locale);
    }
}

if (! function_exists('info')) {
    /**
     * Write some information to the log.
     *
     * @param  string  $message
     * @param  array   $context
     * @return void
     */
    function info($message, $context = [])
    {
        return app('log')->info($message, $context);
    }
}

if (! function_exists('logger')) {
    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return \Illuminate\Contracts\Logging\Log|null
     */
    function logger($message = null, array $context = [])
    {
        if (is_null($message)) {
            return app('log');
        }

        return app('log')->debug($message, $context);
    }
}

if (! function_exists('validator')) {
    /**
     * Create a new Validator instance.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function validator(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $factory = app('validator');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($data, $rules, $messages, $customAttributes);
    }
}
