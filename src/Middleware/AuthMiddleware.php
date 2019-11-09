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
        if (config('souktel-acl.enable')) {
            $request->authUser = new AuthUser([], false);
            return $next($request);
        }
        $token = $request->header(config('souktel-acl.auth.received_token_header'));

        $client = new Client([
            'base_uri' => config('souktel-acl.auth.auth_service.url'),
        ]);

        try {
            $response = $client->request(config('souktel-acl.auth.auth_service.permission_api_method'), config('souktel-acl.auth.auth_service.permission_api_uri'), [
                'form_params' => [],
                'headers'     => [
                    config('souktel-acl.auth.auth_service.token_header') => $token
                ],
            ]);
            if ($response->getStatusCode() == 200) {
                $payload = json_decode($response->getBody()->getContents(), true);
                try {
                    $request->authUser = new AuthUser($payload);
                } catch (\Exception $exception) {
                    return response()->json(['message' => $exception->getMessage()], Response::HTTP_FORBIDDEN);
                }
                return $next($request);
            }
        } catch (RequestException $requestException) {
            // WTF
            //TODO: handle the exception
            return response()->json(['message' => __('messages.response_messages.unauthenticated')], Response::HTTP_FORBIDDEN);
        }

        return response()->json(['message' => __('messages.response_messages.unauthenticated')], Response::HTTP_FORBIDDEN);
    }
}
