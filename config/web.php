<?php

return [
    // 配置文件保存路径,最后不带/
    'sites-path'=>'D:\webpages\apache',

    // 配置信息
    'sites-enabled'=>[
        [
            'domain'=>[
                'www.test.app'
            ],
            'document'=>'/project',
            'port'=>[
                80
            ]
        ],
    ],
];