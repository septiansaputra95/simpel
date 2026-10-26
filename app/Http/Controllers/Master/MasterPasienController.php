<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MMasterpasien;

class MasterPasienController extends Controller
{
    //
    public function index()
    {
        return view('master.pasien.index'); 
    }

    public function loadDatatables(Request $request)
    {
        $data =  MMasterpasien::orderBy('patientname', 'asc')->get();
        // dd($data);

        $query = [];
        $no = 1;
            foreach($data as $item) {
                $query[] = [
                    'id'            => $item->id,
                    'mrn'           => $item->mrn,
                    'patientname'   => $item->patientname,
                    'gender'        => $item->gender,
                    'dateofbirth'   => $item->dateofbirth,
                    'address'       => $item->address,
                    'idbpjs'        => $item->idbpjs,
                    // 'action' => '<button class="btn btn-sm btn-outline-primary" onclick="editDokter(' . $item->id . ')">Edit</button>'
                    'action' => '<button class="btn btn-sm btn-outline-primary" id="btn-edit" onclick="editDokter(' . $item->id . ')" 
                                    data-id="' . $item->id . '">
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
    public function input()
    {
        //
        $mrn = MMasterpasien::orderByDesc('mrn')
                ->value('mrn');
        $newMrn = $mrn ? ((int) $mrn + 1) : 1;
        // dd(auth()->user());
        // dd($mrn, $newMrn);
        $buttonColor = 'bg-accent';
        $buttonName = 'Simpan Data';
        
        return view('master.pasien.input', compact('newMrn', 'buttonColor', 'buttonName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration_date' => 'required',
            'patientname'       => 'required',
            'gender'            => 'required|in:L,P',
            'dateofbirth'       => 'required|date',
            'address'           => 'required',
            'idbpjs'            => 'required',
        ]);

        dd($request);
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
