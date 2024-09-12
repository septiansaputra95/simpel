<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MReferensiDokter;


class ReferensiDokterController extends Controller
{
    //
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        $result = $this->referensiDokter();
        MReferensiDokter::truncate();

        foreach ($result->response as $dokter) {
            MReferensiDokter::create([
                'kodedokter' => $dokter->kodedokter,
                'namadokter' => $dokter->namadokter
            ]);
        echo "data ". $dokter->namadokter . " berhasil disimpan";
        echo "<br>";
        }
    }


    protected function referensiDokter()
    {
        $endpoint = "ref/dokter";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }
}
