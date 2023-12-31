<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RepoFarmasiKonsumsi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FarmasiKonsumsiImport;

class FarmasiKonsumsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $repoFarmasiKonsumsi;

    public function __construct()
    {
        $this->repoFarmasiKonsumsi   = new RepoFarmasiKonsumsi;
    }

    public function index()
    {
        //
        return view('farmasikonsumsi/index');
    }

        
    public function indexAjax(Request $request)
    {
        if ($request->ajax()) {
            $dataRawatJalan = $this->repoFarmasiKonsumsi->getDataKonsumsi($request);
            // dd($dataRawatJalan);
            $no = 1;
            foreach($dataRawatJalan as $val) {

                $query[] = [
                    'no' => $no++,
                    'data_id' => $val->data_id,
                    'nama' => $val->nama,
                    'tanggal' => $val->tanggal,
                    'konsumsi' => $val->konsumsi,
                    'aksiResep' => $this->setButtonResep($val->data_id),
                    'aksiSubResep' => $this->setButtonSubResep($val->data_id),
                    'aksiObatEkse' => $this->setButtonObatEkse($val->data_id),
                    'aksiObatJKN' => $this->setButtonObatJKN($val->data_id)
                ];
            }

            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return response()->json($result);
        }
    }

    // MEMANGGIL GENERATE DI REPO
    public function generateResep(Request $request)
    {
        return $dataResep = $this->repoFarmasiKonsumsi->getResep($request);

    }

    public function generateSubResep(Request $request)
    {
        return $dataResep = $this->repoFarmasiKonsumsi->getSubResep($request);

    }

    // Memanggil GENERATE BIAYA OBAT EXE DI REPO
    public function generateBiayaEkse(Request $request)
    {
        return $dataResep = $this->repoFarmasiKonsumsi->getBiayaObatEkse($request);

    }

    public function generateBiayaJKN(Request $request)
    {
        return $dataResep = $this->repoFarmasiKonsumsi->getBiayaObatJKN($request);

    }

    // Deklarasi untuk button di data tabel
    private function setButtonResep($data_id)
    {
    
        $button = 
            '<button class="btn btn-generateResep btn-success" data-id="'.$data_id.'" id="generateResep">Generate Resep    
        </button>';
        $button .= ' ';
        return $button;
    }

    private function setButtonSubResep($data_id)
    {
    
        $button = 
            '<button class="btn btn-generateSubResep btn-danger" data-id="'.$data_id.'" id="generateSubResep">Generate Sub Resep    
        </button>';
        $button .= ' ';
        return $button;
    }

    private function setButtonObatEkse($data_id)
    {
    
        $button = 
            '<button class="btn btn-generateResep btn-secondary" data-id="'.$data_id.'" id="generateObatEkse">Biaya Obat Ekse    
        </button>';
        $button .= ' ';
        return $button;
    }

    private function setButtonObatJKN($data_id)
    {
    
        $button = 
            '<button class="btn btn-generateSubResep btn-info" data-id="'.$data_id.'" id="generateObatJKN">Biaya Obat JKN    
        </button>';
        $button .= ' ';
        return $button;
    }

    // public function uploadExcel(Request $request)
    // {
    //     //echo "sampai upload";die();
    //     $request->validate([
    //         'upload_file' => 'required|mimes:xlsx,xls',
    //         'nama_petugas' => 'required'
    //     ]);

    //     // menangkap file excel
	// 	$file = $request->file('upload_file');
 
	// 	// membuat nama file unik
	// 	$nama_file = rand().$file->getClientOriginalName();

    //     // upload ke folder file_siswa di dalam folder public
	//     $file->move('file_upload',$nama_file);
    //     //dd($request, $file);

    //     // Proses upload menggunakan Laravel Excel
    //     //Excel::import(new FarmasiKonsumsiImport, $file);
    //    // Excel::import(new FarmasiKonsumsiImport(), public_path('/file_upload/'.$nama_file));

    //     return redirect()->back()->with('success', 'Data berhasil diunggah.');
    // }

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
    // public function simpan(Request $request)
    // {
    //     //
    //     $request->validate([
    //         'upload_file'   => 'required|mimes:xlsx,xls',
    //         'nama_petugas'  => 'required'
    //     ]);

    //     $dataid = date('Ymd').''.rand(1,10000);
    //     //dd($dataid, date('Y-m-d h:m:s'));
    //     $file = $request->file('upload_file');
    //     if ($file->isValid()) {
    //         // File sudah disimpan di variabel $file
    //         // Lanjutkan dengan proses berikutnya
    //         $simpanFarmasiHeader = $this->repoFarmasiKonsumsi->simpanFarmasiKonsumsiHeader($request, $dataid);
    //         //echo "File Excel masuk";
    //         //$import = new FarmasiKonsumsiImport; // Membuat instance dari FarmasiKonsumsiImport
    //         $data = Excel::toCollection($import, $file)->first(); // Mengambil data pertama dari sheet Excel

        
    //         // ...
    //     } else {
    //         // File tidak valid atau tidak berhasil diunggah
    //         // Handle kesalahan di sini
    //         // Contohnya, tampilkan pesan kesalahan kepada pengguna
    //         echo "File Excel Tidak masuk";
    //     }
    //     die();
    //     // Proses upload menggunakan Laravel Excel
    //     //Excel::import(new FarmasiKonsumsiImport, $file);

    //     return redirect()->back()->with('success', 'Data berhasil diunggah.');
    // }

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
