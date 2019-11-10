<?php


return [

    'enable' => true,


    'auth' => [
        'auth_service' => [
            'url'                   => env('AUTH_SERVICE_BASE_URL'),
            'permission_api_uri'    => '/get-user-permissions',
        ],
        'token_header' => [
            'sent'     => 'Authorization',
            'received' => 'Authorization',
        ],
        'invalid_payload_exception' => \Souktel\ACL\Exceptions\InvalidPayloadException::class
    ],

    'acl' => [
        'model'                            => \Souktel\ACL\Models\Permission::class,
        'database'                         => [
            'name_column' => 'name',
            'slug_column' => 'slug'
        ],
        'register_permission_message_name' => 'register-permissions'
    ],


    'this_service' => [
        'key' => 'service_key'
    ],
];
