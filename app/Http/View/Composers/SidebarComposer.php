<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\MMenu;
use App\Models\MRoles;

class SidebarComposer
{
    public function compose(View $view)
    {
        // Jika belum login, kirim sidebar kosong
        if (!auth()->check()) {
            $view->with('menus', collect());
            return;
        }

        // Ambil role user yang login
        $roleName = auth()->user()->role;
        $roleId = MRoles::where('rolesname', $roleName)->value('id');

        // Ambil menu utama yang boleh dilihat
        $menus = MMenu::whereNull('parent_id')
            ->where('is_active', true)
            ->whereHas('roles', function ($q) use ($roleId) {
                $q->where('role_id', $roleId)
                  ->where('can_view', true);
            })
            ->with(['children' => function ($query) use ($roleId) {
                $query->where('is_active', true)
                      ->whereHas('roles', function ($q) use ($roleId) {
                          $q->where('role_id', $roleId)
                            ->where('can_view', true);
                      })
                      ->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // Kirim variabel $menus ke view sidebar
        $view->with('menus', $menus);
    }
}
