<?php

namespace App\Http\Controllers\GudangUmum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MGudangStok;
use App\Models\MMasterGudang;
use App\Models\MMasterBarang;
use App\Models\MSatuan;


class GudangStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('gudangumum.stokgudang.index'); 

    }

    // public function loadDatatables(Request $request)
    public function loadDatatables(Request $request)
    {
        // $request->id = "GUD_UMUM";
        $data = MGudangStok::join(
            'm_master_barangs as b',
            'b.kode_barang',
            '=',
            'm_gudang_stoks.kode_barang'
        )
        ->join(
            'm_master_gudangs as g',
            'g.kode_gudang',
            '=',
            'm_gudang_stoks.kode_gudang'
        )
        ->leftJoin( // pakai LEFT JOIN biar aman kalau satuan belum ada
            'm_satuans as s',
            's.kode_satuan',
            '=',
            'm_gudang_stoks.kode_satuan'
        )
        ->where('m_gudang_stoks.kode_gudang', 'GUD_UMUM')
        ->orderBy('b.nama_barang')
        ->select([
            'm_gudang_stoks.*',
            'b.nama_barang',
            'g.nama_gudang'
        ])
        ->get();
        
        $no = 1;
        foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'nama_gudang' => $item->nama_gudang,
                    'nama_barang' => $item->nama_barang,
                    'nama_satuan' => $item->nama_satuan,
                    'batch_barang' => $item->batch_barang,
                    'stok_barang' => $item->stok_barang,
                    'harga_barang' => 'Rp.'.number_format($item->harga_barang,0,',','.'), 
                    'action' => '<button 
                                    class="btn btn-sm btn-outline-primary btn-edit" 
                                    data-gudangstokid="' . $item->id . '"
                                    data-kode_gudang="' . $item->kode_gudang . '"
                                    >
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
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

    public function getGudang()
    {
        $data = MMasterGudang::get();
        return response()->json($data);
    }

    public function getBarang()
    {
        $data = MMasterBarang::orderBy('nama_barang', 'asc')->get();
        return response()->json($data);
    }

    public function getSatuan()
    {
        $data = MSatuan::get();
        return response()->json($data);
    }

    public function getBarangId($kodebarang)
    {
        $id = MMasterBarang::where('kode_barang', $kodebarang)
        ->value('id');

        return $id;
        
    }

    public function getEdit($gudangstokid)
    {
        $data = MGudangStok::where("id", $gudangstokid)
        ->get();
        // dd("sampek controller", $data);
        return $data;
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
        $gudangid = $this->getGudangId($request->gudang);
        $barangid = $this->getBarangId($request->barang);

        MGudangStok::create([
            'gudang_id'       => $gudangid,
            'barang_id'       => $barangid,
            'kode_gudang'     => $request->gudang,
            'kode_barang'     => $request->barang,
            'batch_barang'    => $this->generateRandomString(7),
            'kode_satuan'     => $request->satuan,
            'expired_date'    => date('2030-12-11'),
            'harga_barang'    => $request->harga,
            'stok_barang'     => $request->stok,
            'is_active'       => $request->isActive
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
        //
        $gudangid = $this->getGudangId($request->gudang);
        $barangid = $this->getBarangId($request->barang);

        MGudangStok::where('id', $request->id)->update([
            'gudang_id'       => $gudangid,
            'barang_id'       => $barangid,
            'kode_gudang'     => $request->gudang,
            'kode_barang'     => $request->barang,
            // 'batch_barang'    => $this->generateRandomString(7),
            'kode_satuan'     => $request->satuan,
            'expired_date'    => '2030-12-11', // langsung string
            'harga_barang'    => $request->harga,
            'stok_barang'     => $request->stok,
            'is_active'       => $request->isActive
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Update Data'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateRandomString($length) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            // Use random_int for secure random index generation
            $index = random_int(0, $charactersLength - 1); 
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public function getGudangId($kodegudang)
    {
        $id = MMasterGudang::where('kode_gudang', $kodegudang)
        ->value('id');

        return $id;
        
    }

    

}
