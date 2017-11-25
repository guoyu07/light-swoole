<?php

namespace LightSwoole\Framework;

use League\Container\Container as BaseContainer;

/**
  * Class Application
  *
  * @package LightSwoole\Framework
  * @author raoyc <raoyc2009@gmaill.com>
  * @link   https://raoyc.com
  */
class Container
{

    /**
     * @var static
     */
    public static $instance = null;

    /**
     * Set the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new BaseContainer();
        }

        return static::$instance;
    }
}