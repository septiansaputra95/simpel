<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MMenu;
use App\Models\MRoles;
use App\Models\MRolesMenus; 

class CheckMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role; // role dari tabel users
        $roleId = MRoles::where('rolesname', $userRole)->value('id');

        // Dapatkan nama route yang sedang diakses
        $currentRoute = $request->route()->getName();

        // Cari menu berdasarkan route
        $menu = MMenu::where('route', $currentRoute)->first();

        // Kalau tidak ada menu terkait, izinkan (misal route umum)
        if (!$menu) {
            return $next($request);
        }

        $hasAccess = \DB::table('m_roles_menus')
            ->where('menu_id', $menu->id)
            ->where('role_id', $roleId)
            ->where('can_view', true)
            ->exists();

        if (!$hasAccess) {
            // Jika tidak punya akses, tolak dengan 403
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }


        return $next($request);
    }
}
