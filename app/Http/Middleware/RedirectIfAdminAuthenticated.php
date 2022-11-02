<?php

namespace App\Http\Middleware;

use App\Config\AppConstants;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $current = Carbon::now(config('app.timezone'))->format('Y-m-d');
        if (adminCheck()) {
            $admin = admin()->user()/*->load(['teams', 'teamLeader'])*/;

            if ($admin->status == AppConstants::ADM_STATUS_ACTIVE && $admin->timeout >= $current) {

                $request->merge(['admin' => $admin]);
                return $next($request);
            }
            admin()->logout();
        }

        return redirect()->route('admin.login');
    }
}
