<?php

namespace App\Http\Controllers\BPJS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MAntrianTanggal;
use App\Models\MLogs;


class AntrianOnlineController extends Controller
{
    // ANTREAN PER TANGGAL
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        return view('bpjs.antrian-tanggal.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
    }

    public function loadDatatables(Request $request)
    {
        $tanggalRegistrasi = $request->input('tanggal') ?? date('Y-m-d');
        //dd($tanggalRegistrasi);
        $dataAntrian = $this->daftarAntrianPerTanggal($tanggalRegistrasi);
        // dd($dataAntrian);

        if ($dataAntrian->metadata->code == 200) {
            $no = 1;
            foreach($dataAntrian->response as $data) {
                $query[] = [
                    'no' => $no++,
                    'kodebooking' => $data->kodebooking,
                    'tanggal' => $data->tanggal,
                    'kodepoli' => $data->kodepoli,
                    'kodedokter' => $data->kodedokter,
                    'nokapst' => $data->nokapst,
                    'nohp' => $data->nohp,
                    'norekammedis' => $data->norekammedis,
                    'jeniskunjungan' => $data->jeniskunjungan,
                    'nomorreferensi' => $data->nomorreferensi,
                    'sumberdata' => $data->sumberdata,
                    'noantrean' => $data->noantrean,
                    'estimasidilayani' => $data->estimasidilayani,
                    'createdtime' => $data->createdtime,
                    'status' => $data->status
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return response()->json($result);
        }
    }

    protected function daftarAntrianPerTanggal($tanggalRegistrasi)
    {
        $endpoint = "antrean/pendaftaran/tanggal/{$tanggalRegistrasi}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }

    public function store(Request $request)
    {
        // Mendapatkan tanggal dari request
        $tanggalRegistrasi = $request->input('tanggal');

        try {
            // Mengambil data antrian berdasarkan tanggal
            $dataAntrian = $this->daftarAntrianPerTanggal($tanggalRegistrasi);

            // Jika kode metadata adalah 200, berarti data ditemukan
            if ($dataAntrian->metadata->code == 200) {

                // Hapus data lama di tabel MAntrianTanggal berdasarkan tanggal
                MAntrianTanggal::where('tanggal', $tanggalRegistrasi)->delete();

                // Menyimpan data baru ke database
                foreach ($dataAntrian->response as $data) {
                    MAntrianTanggal::create([
                        'kodebooking' => $data->kodebooking,
                        'tanggal' => $data->tanggal,
                        'kodepoli' => $data->kodepoli,
                        'kodedokter' => $data->kodedokter,
                        'nokapst' => $data->nokapst,
                        'norekammedis' => $data->norekammedis,
                        'jeniskunjungan' => $data->jeniskunjungan,
                        'nomorreferensi' => $data->nomorreferensi,
                        'sumberdata' => $data->sumberdata,
                        'noantrean' => $data->noantrean,
                        'estimasidilayani' => $data->estimasidilayani,
                        'createdtime' => $data->createdtime,
                        'nohp' => $data->nohp,
                        'status' => $data->status
                    ]);
                }

                // Return response berhasil
                return response()->json([
                    'code' => $dataAntrian->metadata->code,
                    'message' => "Data Berhasil Disimpan",
                ], $dataAntrian->metadata->code);

            } else {
                // Return response jika data tidak ditemukan
                return response()->json([
                    'code' => $dataAntrian->metadata->code,
                    'message' => $dataAntrian->metadata->message,
                ], $dataAntrian->metadata->code);
            }

        } catch (\Exception $e) {
            // Return response jika terjadi kesalahan
            return response()->json([
                'code' => 500,
                'message' => "Terjadi kesalahan: " . $e->getMessage(),
            ], 500);
        }
    }   

    public function digitalClock()
    {
        return view('bpjs.antrian-tanggal.digitalclock');
    }
    
    public function autoStore()
    {
        // $tanggal = DATE('Y-m-d');
        $tanggal = DATE('2025-07-28');

        $request = new Request();
        $request->replace(['tanggal' => $tanggal]);

        $response = $this->store($request);

        $responseData = $response->getData(); 

        echo $pesan = "Pesan: " . $responseData->message . " ". $responseData->code. "<br>";
        echo $pesan2 = "Selesai proses simpan " . $tanggal . ". Mohon di cek.";
        $this->storeLogs($responseData->code, $responseData->message, $pesan, $pesan2);

        return redirect()->route('antrianonline.digitalclock');
        return $response;
        
    }

    public function storeLogs($code, $message, $pesan, $pesan2)
    {
        MLogs::create([
            'metode'        => 'GET',
            'api'           => 'Antrian Per Tanggal',
            'controller'    => 'AntrianOnlineController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan.' '. $pesan2
        ]);
    }
}
