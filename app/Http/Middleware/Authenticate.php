<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login.show');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $routeName = $request->route()->getName();

        $routeName = explode('.', $routeName)[0];

        if (!is_null($request->user()) && !(in_array($routeName, config('defaultpermissions')) || $request->user()->hasPermission($routeName))) {
            abort(403, 'You do not have access to this page');
        }

        return parent::handle($request, $next, ...$guards);
    }
}
