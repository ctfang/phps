#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 10:27
 */

define('ROOT_PATH',__DIR__);

require ROOT_PATH.'/vendor/autoload.php';
require ROOT_PATH.'/src/Init.php';

$app = new \Symfony\Component\Console\Application();

$config = include ROOT_PATH . '/config/config.php';

foreach ($config as $nameSpace){
    $app->add(new $nameSpace());
}

$app->run();