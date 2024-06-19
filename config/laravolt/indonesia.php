<?php

return [
    'table_prefix' => 'id_',
    'route' => [
        'enabled' => false,
        'middleware' => ['web', 'auth'],
        'prefix' => 'id',
    ],
    'view' => [
        'layout' => 'ui::layouts.app',
    ],
    'menu' => [
        'enabled' => false,
    ],
];
