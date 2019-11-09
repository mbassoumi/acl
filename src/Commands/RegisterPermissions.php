<?php

namespace Souktel\ACL\Commands;

use Illuminate\Console\Command;

/**
 * register data collection permissions in other services like
 * Auth Service and IGPA.
 * This command used just one time when you this service in a system
 * In IGPA case, you need to call this command twice for IGPA and AUTH services
 *
 * php artisan permissions:register auth-service
 * php artisan permissions:register igpa
 *
 * Class RegisterPermissions
 * @package App\Console\Commands
 */
class RegisterPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:register {queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register Permission.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $queue = $this->argument('queue');

        if (is_null($queue)) {
            $this->error('invalid queue name');
            return;
        }

        $permissionModel = config('souktel-acl.acl.model');
        $permissions = $permissionModel::query()->select([config('souktel-acl.acl.database.name_column') . ' as name', config('souktel-acl.acl.database.slug_column') . ' as slug'])->get()->toArray();
        $message = [
            'permissions' => $permissions,
            'service'     => config('souktel-acl.this_service.key')
        ];
        app('MessageBroker')->publish(config('souktel-acl.acl.register-permission-event-name'), json_encode($message), $queue);
    }
}
