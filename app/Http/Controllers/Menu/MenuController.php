<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MMenu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('menu.index');

    }
    public function loadDatatables(Request $request)
    {
        $data = MMenu::orderBy('id')->get();
        

        return response()->json([
            'data' => $data
        ]);
    }
    public function getParent(Request $request)
    {
        $data = MMenu::whereNull('parent_id')->get();
        // $data = DB::select('SELECT * FROM m_menus WHERE parent_id IS NULL');
        // dd($data->toArray());
        // dd($data);
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $lastOrder = MMenu::where('parent_id', $request->parent_id)
                            ->max('order');

        $nextOrder = $lastOrder ? $lastOrder + 1 : 1; // kalau null, mulai dari 1
        // dd($lastId);

        // MMenu::create([
        //     'menuname'      => $request->menuname,
        //     'route'         => $request->route,
        //     'icon'          => $request->icon,
        //     'parent_id'     => $request->parent_id,
        //     'order'         => $nextOrder,
        //     'is_active'     => $request->is_active
        // ]);

        return response()->json(['status' => '200', 'message' => 'Berhasil Simpan Data']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
