#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 10:27
 */

require __DIR__.'/vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();

$config = include __DIR__ . '/config/config.php';

foreach ($config as $nameSpace){
    $app->add(new $nameSpace());
}

$app->run();