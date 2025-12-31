<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MRoles;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('user.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
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
                    'action' => '<button class="btn btn-sm btn-outline-primary" id="btn-edit" onclick="edit user(' . $item->id . ')" 
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
                    'action' => '<button class="btn btn-sm btn-outline-primary" id="btn-edit-role" onclick="edit-roles(' . $item->id . ')" 
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
            'roles' => function ($q) use ($roleId) {
                $q->where('roles.id', $roleId);
            },
            'children'
        ])
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();

        return view('menu.modal-data-access', compact('menus', 'roleId'));
    }
}
