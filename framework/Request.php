<?php

namespace LightSwoole\Framework;


/**
  * Request Application
  *
  * @package LightSwoole\Framework
  * @author raoyc <raoyc2009@gmaill.com>
  * @link   https://raoyc.com
  */
class Request
{

    /**
     * get Query Params by key
     * 
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        $params = container('request')->getQueryParams();
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }

    /**
     * get Post Params by key
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function post($key = null, $default = null)
    {
        $params = container('request')->getParsedBody();
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }

    /**
     * get Request Params (merge query and post params)
     * 
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function input($key = null, $default = null)
    {
        $gets = self::get();
        $posts = self::post();
        $params = array_merge($gets, $posts);
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }

    /**
     * get Server Params
     * 
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function server($key = null, $default = null)
    {
        $params = container('request')->getServerParams();
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }

    /**
     * get Cookie Params
     * 
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function cookie($key = null, $default = null)
    {
        $params = container('request')->getCookieParams();
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }


    /**
     * get Uploaded Files
     * 
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function file($key = null, $default = null)
    {
        $params = container('request')->getUploadedFiles();
        if (is_null($key)) {
            return $params;
        }
        return isset($params[$key]) ? $params[$key] : $default;
    }

    /**
     * get current Url
     * 
     * @return \Zend\Diactoros\Uri
     */
    public static function url()
    {
        return container('request')->getUri();
    }

    /**
     * get current Host
     * 
     * @return string
     */
    public static function host()
    {
        return container('request')->getHostFromUri();
    }

    /**
     * method
     * 
     * @return string
     */
    public static function method()
    {
        return container('request')->getMethod();
    }

    /**
     * isPost
     * 
     * @return boolean
     */
    public static function isPost()
    {
        return strtolower(self::method()) == 'post';
    }

    /**
     * isGet
     * 
     * @return boolean
     */
    public static function isGet()
    {
        return strtolower(self::method()) == 'get';
    }

    /**
     * isPut
     * 
     * @return boolean
     */
    public static function isPut()
    {
        return strtolower(self::method()) == 'put';
    }

    /**
     * isPatch
     * 
     * @return boolean
     */
    public static function isPatch()
    {
        return strtolower(self::method()) == 'patch';
    }

    /**
     * isDelete
     * 
     * @return boolean
     */
    public static function isDelete()
    {
        return strtolower(self::method()) == 'delete';
    }

    /**
     * isHead
     * 
     * @return boolean
     */
    public static function isHead()
    {
        return strtolower(self::method()) == 'head';
    }

    /**
     * isOptions
     * 
     * @return boolean
     */
    public static function isOptions()
    {
        return strtolower(self::method()) == 'options';
    }

}