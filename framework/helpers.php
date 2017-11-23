<?php

use Noodlehaus\Config;
use LightSwoole\Framework\Translator;

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
        $translator = new Translator();
        return $translator->trans($id, $parameters, $domain, $locale);
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
        $translator = new Translator();
        return $translator->transChoice($id, $number, $parameters, $domain, $locale);
    }
}