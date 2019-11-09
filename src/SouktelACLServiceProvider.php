<?php

namespace Souktel\ACL;

use Souktel\ACL\Commands\RegisterPermissions;
use Illuminate\Support\ServiceProvider;
use Souktel\ACL\Middleware\AuthMiddleware;
use Souktel\ACL\Middleware\HasPermission;


class SouktelACLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/souktel-acl.php' => config_path('souktel-acl.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/create_permissions_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_' . config('souktel-acl.acl.database.table') . '_table.php'),
        ], 'migrations');

    }

    public function register()
    {
        $this->app->routeMiddleware([
            'service.auth' => AuthMiddleware::class,
            'has-permission' => HasPermission::class,
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/souktel-acl.php', 'souktel-acl'
        );


        $this->app->bind('command.permissions:register', RegisterPermissions::class);

        $this->commands([
            'command.permissions:register',
        ]);

    }
}
