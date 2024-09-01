<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MAntrianTanggal;
use App\Models\MTaskList;
use Bpjs\Bridging\Antrol\BridgeAntrol;

class UpdateTaskController extends Controller
{
    //
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        return view('bpjs.update-task.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
    }

    public function getKodeBooking(Request $request)
    {
        $data = MTaskList::where('kodebooking', $request->kodebooking)
                        ->where('taskid', $request->caritask)
                        ->get();
        
        return response()->json($data);

    }
    public function postTask(Request $request)
    {
        $kodebooking = $request->input('kodebooking');
        $taskid = $request->input('taskid');
        $newTime = $request->input('newTime');

        //dd($kodebooking, $taskid, $newTime);
        $dataAntrian = $this->updateWkatu($kodebooking, $taskid, $newTime);
        return response()->json($dataAntrian);
    }

    protected function updateWkatu($kodebooking, $taskid, $newTime)
    {

        $data = [
            'kodebooking' => $kodebooking,
            'taskid' => $taskid,
            'waktu' => $newTime
        ];

        //dd($data);
        return $data;
        
        
        // $dataRequest = json_encode($data);

        // $endpoint = 'antrean/updatewaktu';
        // $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        // $result = json_decode($requestBridge);
        // return $result;
    }
}
