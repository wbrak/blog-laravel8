<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EnsureUserRoleIsAllowedToAccess
{
    // dashboard, pages, navigation-menus

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $userRole = auth()->user()->role;
            $currentRouteName = Route::currentRouteName();

            if (in_array($currentRouteName, $this->userAccessRole()[$userRole]))
            {
                return $next($request);
            } else
            {
                abort(403, 'Unauthorized Action.');
            }
        } catch (\Throwable $th)
        {
            abort(403, 'Unauthorized Action.');
        }

    }

    /**
     * The list of accessible resource for a specific user.
     * We will store this in the database late.
     *
     * @return array
     */
    private function userAccessRole()
    {
        return [
            'user' => [
                'dashboard'
            ],
            'admin' => [
                'dashboard',
                'pages',
                'navigation-menus',
                'users',
                'user-permissions',
            ],
        ];
    }
}
