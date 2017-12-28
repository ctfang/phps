<?php

return [
    // 配置文件保存路径,最后不带/
    'sites-path'=>'D:\webpages\apache',

    // apache配置的模板
    'vhost'=>__DIR__.'/../packers/web/vhost.example',

    // 配置信息
    'sites-enabled'=>[
        [
            'domain'=>[
                'www.test.app'
            ],
            'document'=>'/project',
            'port'=>80
        ],
    ],
];