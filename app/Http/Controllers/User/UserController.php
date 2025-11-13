<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('user.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
    }

    public function loadDatatables(Request $request)
    {
        
        $data = User::select('username', 'nama')->get();
        dd($data);

        if ($data->metadata->code == 200) {
            $no = 1;
            foreach($data->response as $data) {
                $query[] = [
                    'no' => $no++,
                    'username' => $data->username,
                    'nama' => $data->nama
                ];
            }
            dd($query);
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return response()->json($result);
        }
    }
}
