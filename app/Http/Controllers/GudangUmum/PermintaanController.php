<?php

namespace App\Http\Controllers\GudangUmum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MPermintaanHeader;
use App\Models\User;
use App\Models\MUnit;
use Carbon\Carbon;


class PermintaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('gudangumum.permintaan.index');
    }

    public function input()
    {
        //
        return view('gudangumum.permintaan.input');
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

    public function loadDatatables(Request $request)
    {
        // $request->id = "GUD_UMUM";
        $data = MPermintaanHeader::leftjoin(
            'users as b',
            'b.id',
            '=',
            'm_permintaan_headers.user_id'
        )
        ->leftjoin(
            'm_units as g',
            'g.id',
            '=',
            'm_permintaan_headers.unit_id'
        )
        // ->leftJoin( // pakai LEFT JOIN biar aman kalau satuan belum ada
        //     'm_satuans as s',
        //     's.kode_satuan',
        //     '=',
        //     'm_gudang_stoks.kode_satuan'
        // )
        // ->where('m_gudang_stoks.kode_gudang', 'GUD_UMUM')
        ->orderBy('m_permintaan_headers.tanggal_permintaan')
        // ->select([
        //     'm_gudang_stoks.*',
        //     'b.nama_barang',
        //     'g.nama_gudang'
        // ])
        ->get();
        
        $no = 1;
        foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'kode_permintaan' => $item->kode_permintaan,
                    'tanggal_permintaan' => Carbon::parse($item->tanggal_permintaan)->format('d-m-Y'),
                    'unitnama' => $item->unitnama,
                    'total_harga' => 'Rp.'.number_format($item->total_harga,0,',','.'),
                    'keterangan' => $item->keterangan,
                    'nama' => $item->nama, 
                    'action' => '<button 
                                    class="btn btn-sm btn-outline-primary btn-edit" 
                                    data-permintaanid="' . $item->id . '"
                                    >
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                                <button 
                                    class="btn btn-sm btn-outline-danger btn-print" 
                                    data-permintaanid="' . $item->id . '"
                                    >
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </button>'
                ];
            }
        if (empty($query)) {
            return response()->json(['data' => []]);
        }

        return response()->json([
            'data' => $query
        ]);
        
    }

    public function getTanggalPermintaanAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    // Mutator (Input → DB)
    public function setTanggalPermintaanAttribute($value)
    {
        // terima format dd-mm-YYYY dari frontend
        $this->attributes['tanggal_permintaan'] =
            Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
