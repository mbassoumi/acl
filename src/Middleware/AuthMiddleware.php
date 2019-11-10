<?php


namespace Souktel\ACL\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Souktel\ACL\Classes\AuthUser;
use Symfony\Component\HttpFoundation\Response;

/**
 * middleware for all auth apis, talk with auth service to check if the provided token is valid or not
 * if is valid a payload retrieved from auth  service with user details and permissions
 *
 * Class AuthMiddleware
 * @package App\Http\Middleware
 */
class AuthMiddleware
{

    public function handle(Request $request, Closure $next, $guard = null)
    {
        /*
         * skip usage of this middleware if auth is not enabled.
         */
        if (!config('souktel-acl.enable')) {
            $request->authUser = new AuthUser([], false);
            return $next($request);
        }
        $token = $request->header(config('souktel-acl.auth.token_header.received'));

        $client = new Client([
            'base_uri' => config('souktel-acl.auth.auth_service.url'),
        ]);

        $response = $client->request('GET', config('souktel-acl.auth.auth_service.permission_api_uri'), [
            'form_params' => [],
            'headers'     => [
                config('souktel-acl.auth.token_header.sent') => $token
            ],
        ]);
        if ($response->getStatusCode() == 200) {
            $payload = json_decode($response->getBody()->getContents(), true);
            $request->authUser = new AuthUser($payload);
            return $next($request);
        }

        return response()->json(['message' => 'UNAUTHENTICATED'], Response::HTTP_FORBIDDEN);
    }

}
