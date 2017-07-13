<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-13
 * Time: 14:36
 */

if(! function_exists('user'))
{
    /**
     * @param null $driver
     * @return mixed
     */
    function user($driver = null)
    {
        if($driver)
        {
            return app('auth')->guard($driver)->user();
        }
        return app('auth')->user();
    }
}