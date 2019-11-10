<?php


namespace Souktel\ACL\Classes;



use Illuminate\Support\Arr;


/**
 * a class appended to request in AuthMiddleware that saves token payload inside it
 * and do [can] function
 *
 * Class AuthUser
 * @package App\Http\Requests
 */
class AuthUser
{

    protected $user = [
        'id'    => null,
        'name'  => null,
        'email' => null
    ];

    protected $permissions = [];

    /**
     * AuthUser constructor.
     * @param array $payload
     * @param bool $validation
     * @throws \Exception
     */
    public function __construct(array $payload, $validation = true)
    {
        /*
         * payload => [
         *      'user' => [...user_details],
         *      'permissions' => [...user_permissions]
         * ]
         */
        if ($validation) {
            $payloadRequiredKeys = ['user.id', 'user.name', 'user.email', 'permissions'];

            if (Arr::has($payload, $payloadRequiredKeys) and is_array($payload['permissions'])) {
                $this->permissions = $payload['permissions'];
                $this->user = $payload['user'];
            } else {
                $exception = config('souktel-acl.auth.invalid_payload_exception');
                throw new $exception();
            }
        } else {
            $permissionModel = config('souktel-acl.acl.model');
            $this->permissions = $permissionModel::query()->pluck(config('souktel-acl.acl.database.slug_column'))->toArray();
        }

    }

    /**
     * check if token has permission/s [$action]
     *
     * @param $action
     * @return bool
     */
    public function can($action)
    {
        $actions = (array)$action;
        $diff = array_diff($actions, $this->permissions);
        return empty($diff);
    }

    /**
     * get user permissions from token
     *
     * @return array|mixed
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * get user details from token
     *
     * @return array|mixed
     */
    public function getUserInfo()
    {
        return $this->user;
    }

    public function getAuthUserId()
    {
        return $this->user['id'];
    }
}
