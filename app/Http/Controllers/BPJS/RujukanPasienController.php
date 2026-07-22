<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\MAntrianTanggal;

class RujukanPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }

    public function index()
    {
        //
        $tanggal = DATE('Y-m-d');
        $data = MAntrianTanggal::where('tanggal', $tanggal)->get();

        foreach ($data as $item) {
            $nokartu = $item->nokapst;
            $dataRujukan = $this->getRujukanPasien($nokartu);
            $rujukan = $dataRujukan->response->rujukan;
            $metaData = $rujukan->metaData;
            $code = $metaData->code;
            $message = $metaData->message;

        }
    }

    protected function getRujukanPasien($nokartu)
    {

        $endpoint = "Rujukan/Peserta/{$nokartu}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
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
}