<?php

namespace App\Http\Controllers\BPJS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MAntrianTanggal;
use App\Models\MTaskList;


class TaskListController extends Controller
{
    // ANTREAN PER TANGGAL
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        return view('bpjs.task-list.index'); // Pastikan view ini ada di resources/views/bpjs/index.blade.php
    }

    public function loadDatatables(Request $request)
    {
        $kodeBooking = $request->input('kodebooking');
        $dataAntrian = $this->taskListKodeBooking($kodeBooking);
            //    dd($dataAntrian);

        if ($dataAntrian->metadata->code == 200) {
            $no = 1;
            foreach($dataAntrian->response as $data) {
                $query[] = [
                    'no' => $no++,
                    'wakturs' => $data->wakturs,
                    'waktu' => $data->waktu,
                    'taskname' => $data->taskname,
                    'taskid' => $data->taskid,
                    'kodebooking' => $data->kodebooking
                ];
            }
            $result = isset($query) ? ['data' => $query] : ['data' => 0];
            return response()->json($result);
        } else {
            $result = ['data' => 0];
            return response()->json($result);
        }
    }

    protected function taskListKodeBooking($kodebooking)
    {

        $data = [
            'kodebooking' => $kodebooking
        ];

        
        $dataRequest = json_encode($data);

        $endpoint = 'antrean/getlisttask';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        $result = json_decode($requestBridge);
        
        // $metadata = $result->metadata ?? null;
        // dd($metadata);
        // if ($metadata) {
        //     $code = $metadata->code?? null;
        //     $message = $metadata->message ?? null;

        //     $pesan = $kodebooking;
        //     $pesan2 = " " ;

        //     $this->storeLogs($code, $message, $pesan, $pesan2);

        // } else {
        //     $this->storeLogs('Unknown', 'No metadata in response', 'Response: ' . $requestBridge, 'Failed to fetch valid response. Kode Booking: ', '');
        // }

        return $result;

    }

    public function getTaskTanggal(Reqest $request)
    {
        $tanggal = $request->tanggal;
        $data = MTasklist::where('wakturs', 'LIKE'. "%{$tanggal}%")
                ->with('Antrian')
                ->get();
    }
    public function getKodeBooking(Request $request)
    {
        $data = MAntrianTanggal::where('tanggal', $request->tanggal)->get();
        
        // $result = isset($data) ? ['data' => $data] : ['data' => 0];
        // return response()->json($result);
        return response()->json($data);

    }

    public function store(Request $request)
    {
    
        try {
            
            $kodeBooking = $request->input('kodebooking');
            $tanggal = $request->input("tanggal");
            //dd($kodeBooking, $tanggal);
            $dataAntrian = $this->taskListKodeBooking($kodeBooking);

            //dd($tanggal);
            if (isset($dataAntrian->response) && is_array($dataAntrian->response)) {
                MTaskList::where('kodebooking', $kodeBooking)->delete();
                foreach($dataAntrian->response as $data) {
                    
                    MTaskList::create([
                        'kodebooking' => $data->kodebooking,
                        'wakturs' => $data->wakturs,
                        'waktu' => $data->waktu,
                        'taskname' => $data->taskname,
                        'taskid' => $data->taskid,
                        'tanggal_data' => $tanggal
                    ]);
                }

                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil disimpan'
                ], 200);

            }  else if($dataAntrian->metadata->message == "No Content")
            {
                //dd($dataAntrian->metadata->code, $dataAntrian->metadata->message, "metadata 1");
                MTaskList::where('kodebooking', $kodeBooking)->delete();
                MTaskList::create([
                    'kodebooking' => $kodeBooking,
                    'wakturs' => '0',
                    'waktu' => '0',
                    'taskname' => 'Tidak Ada Satu Task List Pun',
                    'taskid' => '0',
                    'tanggal_data' => $tanggal
                ]);

                return response()->json([
                    'code' => 200,
                    'message' => 'Data berhasil disimpan dengan pesan "No Content" '
                ], 200);
            }
            else {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data antrian tidak valid atau tidak ditemukan.'
                ], 400);
            }

        } catch (\Exception $e) {
            // Return response jika terjadi kesalahan
            return response()->json([
                'code' => 500,
                'message' => "Terjadi kesalahan Store Function: " . $e->getMessage(),
            ], 500);
        }
    }   

    public function digitalClock()
    {
        return view('bpjs.task-list.digitalclock');
    }
    
    public function autoStore()
    {
        // $tanggal = DATE('Y-m-d');
        $tanggal = DATE('2025-05-15');

        $request = new Request();
        $request->replace(['tanggal' => $tanggal]);

        $response = $this->getKodeBooking($request);
        $responseData = $response->getData();

        foreach ($responseData as $item) {
            $request->replace(['tanggal' => $tanggal, 'kodebooking' => $item->kodebooking]);
            $data = $this->store($request);
            echo "Data ". $item->kodebooking. " Berhasil Di Simpan";
            echo "<br>";
        }
        return redirect()->route('tasklist.digitalclock');
    }

    public function storeLogs($code, $message, $pesan, $pesan2)
    {
        MLogs::create([
            'metode'        => 'POST',
            'api'           => 'Task List',
            'controller'    => 'TaskListController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan.' '. $pesan2
        ]);
    }
}
