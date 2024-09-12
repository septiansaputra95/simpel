<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MReferensiPoli;


class ReferensiPoliController extends Controller
{
    //
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        $result = $this->referensiPoli();
        MReferensiPoli::truncate();

        foreach ($result->response as $data) {
            MReferensiPoli::create([
                'kdpoli' => $data->kdpoli,
                'kdsubspesialis' => $data->kdsubspesialis,
                'nmpoli' => $data->nmpoli,
                'nmsubspesialis' => $data->nmsubspesialis
            ]);
        echo "data ". $data->nmpoli . " berhasil disimpan";
        echo "<br>";
        }
    }


    protected function referensiPoli()
    {
        $endpoint = "ref/poli";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }

}
