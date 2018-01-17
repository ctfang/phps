<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/15
 * Time: 18:27
 */

use Dotenv\Dotenv;

if( file_exists(ROOT_PATH) ){
    $env = new Dotenv(ROOT_PATH);
    $env->load();
}else{
    copy(ROOT_PATH . '/.env.example',ROOT_PATH . '/.env');
    $env = new Dotenv(ROOT_PATH);
    $env->load();
}

function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return null;
    }

    if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
        return substr($value, 1, -1);
    }

    return $value;
}