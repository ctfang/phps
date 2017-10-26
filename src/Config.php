<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 19:26
 */

class Config
{
    public static function get($file)
    {
        return include_once __DIR__.'/../config/'.$file.'.php';
    }
}