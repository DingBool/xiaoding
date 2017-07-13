<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-06-28
 * Time: 11:11
 */

namespace App;
/**
 * Class Settings
 * @package App
 */
class Settings
{
    /**
     * @var array
     */
    protected $allowed = ['city','bio'];
    /**
     * @var
     */
    protected $user;

    /**
     * Settings constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function merge(array $attributes)
    {
        $setting = array();
        $settings = json_encode(array_merge($setting,array_only($attributes,$this->allowed)));
        return $this->user->update(['settings'=>$settings]);
    }
}