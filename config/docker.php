<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/25
 * Time: 19:24
 */
return [
    /**
     * a, docker命令进入的目录
     * b, 进入命令使用docker-compose [option]
     */
    'dir'=>env('DOCKER_COMPOSE'),
    /**
     * 到处images目录保存的目录
     */
    'save_dir'=>env('DOCKER_SAVE'),
];