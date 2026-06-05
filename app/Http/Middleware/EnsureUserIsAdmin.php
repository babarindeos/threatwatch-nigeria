<?php
// ====================================================================
// FILE: app/Http/Middleware/EnsureUserIsAdmin.php
// ====================================================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowed = empty($roles)
            ? ['super_admin', 'moderator']
            : $roles;

        if (! in_array($request->user()->role, $allowed, true)) {
            abort(403, 'You do not have permission to access this area.');
        }

        return $next($request);
    }
}
