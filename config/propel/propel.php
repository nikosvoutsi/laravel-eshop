<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter'    => 'mysql',
                    'dsn'        => 'mysql:host=localhost; port=3386; dbname=cl_marketplace',
                    'user'       => 'root',
                    'password'   => '',
                    'settings' => [
                        'charset'=>'utf8mb4'
                    ]
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ],
        'generator' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ]
    ]
];