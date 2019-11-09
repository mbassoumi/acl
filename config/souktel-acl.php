<?php


return [

    'enable' => true,


    'auth' => [
        'auth_service' => [
            'url'                   => env('AUTH_SERVICE_BASE_URL'),
            'permission_api_method' => 'GET',
            'permission_api_uri'    => '/get-user-permissions',
            'token_header'          => 'Authorization',
        ],
        'token_header' => 'Authorization',
    ],

    'acl' => [
        'model'    => \Souktel\ACL\Models\Permission::class,
        'database' => [
            'table'       => 'permissions',
            'name_column' => 'name',
            'slug_column' => 'slug'
        ],
        'register-permission-message-name' => 'register-permissions'
    ],


    'this_service' => [
        'key' => 'service_key'
    ],
];
