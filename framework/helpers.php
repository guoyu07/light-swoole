<?php

use Noodlehaus\Config;

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