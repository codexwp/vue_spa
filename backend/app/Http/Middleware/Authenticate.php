<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $role = null)
    {
        $cookie_name = env('AUTH_COOKIE_NAME');

        if (!$request->bearerToken()) {
            if ($request->hasCookie($cookie_name)) {
                $token = $request->cookie($cookie_name);
                $request->headers->add([
                    'Authorization' => 'Bearer ' . $token
                ]);
            }
        }

        if($this->auth->guard($guard)->guest())
            return response()->json(['message' => 'Unauthorized'], 401);

        if($role) {
            $auth_user = auth()->user();
            if ($auth_user->role !== $role)
                return response()->json(['message' => 'Permission denied'], 412);
        }

        return $next($request);;
    }
}
