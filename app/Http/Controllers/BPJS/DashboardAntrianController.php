<?php

namespace App\Http\Controllers\BPJS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bpjs\Bridging\Antrol\BridgeAntrol;

class DashboardAntrianController extends Controller
{
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        return view('bpjs.dashboard.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
    }

    public function loadDatatables(Request $request)
    {
        $tanggalRegistrasi = date('Y-m-d');
        $waktustring = "rs";
        $dataAntrian = $this->dashboardAntrianPerTanggal($tanggalRegistrasi, $waktustring);
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

    protected function dashboardAntrianPerTanggal($tanggalRegistrasi, $waktustring)
    {
        $endpoint = "dashboard/waktutunggu/tanggal/{$tanggalRegistrasi}/waktu/{$waktustring}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }
}
