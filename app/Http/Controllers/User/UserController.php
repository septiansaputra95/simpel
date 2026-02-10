<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MRoles;
use App\Models\MMenu;
use App\Models\MRolesMenu;


class UserController extends Controller
{
    //
    public function index()
    {
        return view('user.index');
    }

    public function loadDatatables(Request $request)
    {
        
        $data = User::select('id', 'username', 'nama', 'role')->get();
        // dd($data);

        $no = 1;
            foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'username' => $item->username,
                    'nama' => $item->nama,
                    'role' => $item->role,
                    'action' => '<button class="btn btn-sm btn-outline-primary btn-edit" id="btn-edit"
                                    data-id="' . $item->id . '" 
                                    data-username="' . $item->username . '" 
                                    data-nama="' . $item->nama . '"
                                    data-role="' . $item->role . '"> 
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>'
                ];
            }
        if (empty($query)) {
            return response()->json(['data' => []]);
        }

        return response()->json(['data' => $query]);

    }

    public function rolesloadDatatables(Request $request)
    {
        
        $data = MRoles::get();
        // dd($data);

        $no = 1;
            foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'rolesname' => $item->rolesname,
                    'description' => $item->description,
                    'action' => '<button class="btn btn-sm btn-outline-primary btn-edit-role" id="btn-edit-role" 
                                    data-id="' . $item->id . '" 
                                    data-rolesname="' . $item->rolesname . '" 
                                    data-description="' . $item->description . '">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning btn-access-role" 
                                    data-id="' . $item->id . '" 
                                    data-rolesname="' . $item->rolesname . '" 
                                    data-description="' . $item->description . '">
                                    <i class="fa fa-gears" aria-hidden="true"></i>
                                </button>'
                ];
            }
        if (empty($query)) {
            return response()->json(['data' => []]);
        }

        return response()->json(['data' => $query]);

    }

    public function accessRole($roleId)
    {
        $menus = MMenu::with([
            'children.roles' => fn ($q) => $q->where('m_roles.id', $roleId)
        ])
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();
    //    dd("sudah sampai access Role". $menus);

        $result = [];

        foreach ($menus as $parent) {
            foreach ($parent->children as $menu) {
                $pivot = $menu->roles->first()?->pivot;

                $result[] = [
                    'parent'     => $parent->menuname,
                    'menu_id'    => $menu->id,
                    'menuname'   => $menu->menuname,
                    'can_view'   => (bool) ($pivot->can_view ?? false),
                    'can_create' => (bool) ($pivot->can_create ?? false),
                    'can_edit'   => (bool) ($pivot->can_edit ?? false),
                    'can_delete' => (bool) ($pivot->can_delete ?? false),
                ];
            }
        }

        return response()->json($result);
    }

    public function updateAccessRole(Request $request, $roleId)
    {
        // dd("udah sampek updateAccessRole ". $request);
        foreach ($request->akses as $menuId => $perm) {

            MRolesMenu::updateOrCreate(
                [
                    'role_id' => $roleId,
                    'menu_id' => $menuId,
                ],
                [
                    'can_view'   => $perm['view'] ?? 0,
                    'can_create' => $perm['create'] ?? 0,
                    'can_edit'   => $perm['edit'] ?? 0,
                    'can_delete' => $perm['delete'] ?? 0,
                ]
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Hak akses berhasil diperbarui'
        ]);
    }
}
