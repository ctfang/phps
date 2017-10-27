<?php
return array(
    'sites-path'    => 'D:\\webpages\\apache',
    'vhost'         => 'D:\\phps\\config/../packers/web/vhost.example',
    'sites-enabled' =>
        array(
            0 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'www.blog.app',
                        ),
                    'document' => '/project/blog/public',
                ),
            1 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'www.crm-offline.app',
                            1 => 'api.crm-offline.app',
                            2 => 'wechat.crm-offline.app',
                        ),
                    'document' => '/project/crm-offline/public',
                ),
            2 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'www.crm-saas.app',
                        ),
                    'document' => '/project/crm-saas/public',
                ),
            3 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'www.full_crm.app',
                        ),
                    'document' => '/project/full_crm/public',
                ),
            4 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'ppe.app',
                            1 => 'www.ppe.app',
                        ),
                    'document' => '/project/ppe/public',
                ),
            5 =>
                array(
                    'port'     => '80',
                    'domain'   =>
                        array(
                            0 => 'www.tp5.app',
                        ),
                    'document' => '/project/tp5/public',
                ),
        ),
);
