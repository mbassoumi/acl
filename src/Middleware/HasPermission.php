<?php

namespace Souktel\ACL\Middleware;

use Closure;
use Illuminate\Http\Response;

/**
 * a middleware to check if the token has permission to access this api or not!
 *
 * Class HasPermission
 * @package App\Http\Middleware
 */
class HasPermission
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param array|string $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        if (!config('souktel-acl.enable')) {
            return $next($request);
        }
        if (!$request->authUser->can($permissions)) {
            return response()->json(['message' => 'UNAUTHORIZED'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
