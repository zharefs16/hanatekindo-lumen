<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $username = env('BASIC_AUTH_USERNAME');
        $password = env('BASIC_AUTH_PASSWORD');

        if ($request->getUser() !== $username || $request->getPassword() !== $password) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response('Unauthorized', 401, $headers);
        }

        return $next($request);
    }
}
