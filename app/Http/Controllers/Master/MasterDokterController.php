<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MMasterDokter;

class MasterDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.dokter.index'); 
    }

    public function loadDatatables(Request $request)
    {
        $data =  MMasterDokter::orderBy('namadokter', 'asc')->get();
        // dd($data);

        $query = [];
        $no = 1;
            foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'kodedokter' => $item->kodedokter,
                    'namadokter' => $item->namadokter,
                    'emaildokter' => $item->emaildokter,
                    // 'action' => '<button class="btn btn-sm btn-outline-primary" onclick="editDokter(' . $item->id . ')">Edit</button>'
                    'action' => '<button class="btn btn-sm btn-outline-primary" id="btn-edit" onclick="editDokter(' . $item->id . ')" 
                                    data-id="' . $item->id . '" 
                                    data-kodedokter="' . $item->kodedokter . '" 
                                    data-namadokter="' . $item->namadokter . '" 
                                    data-emaildokter="' . $item->emaildokter . '">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>'
                ];
            }
        // dd($query);
        // $result = isset($query) ? ['data' => $query] : ['data' => 0];
        // return response()->json($result);
        if (empty($query)) {
            return response()->json(['data' => []]);
        }
    
        return response()->json(['data' => $query]);
        
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
        $lastDokter = MMasterDokter::orderBy('id', 'DESC')->first();

        if ($lastDokter) {
            $lastId = $lastDokter->id + 1;
        } else {
            $lastId = null; // Jika tidak ada data, kembalikan null
        }

        \Log::info('Data yang diterima:', $request->all());
        \Log::info('Masuk ke store method');
        MMasterDokter::create([
            'id'             => $lastId,
            'kodedokter'     => $request->kodedokter,
            'namadokter'     => $request->namadokter,
            'emaildokter'    => $request->emaildokter,
            'nomorhp'        => $request->nomorhp
        ]);

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
    public function update(Request $request)
    {
        \Log::info('Data yang diterima:', $request->all());
        \Log::info('Masuk ke update method');

        MMasterDokter::where('kodedokter', $request->kodedokter)
                     ->update([
                        'namadokter'     => $request->namadokter,
                        'emaildokter'    => $request->emaildokter
                     ]);

        return response()->json(['status' => '200', 'message' => 'Berhasil Update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
