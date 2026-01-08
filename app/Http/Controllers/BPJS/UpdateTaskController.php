<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MAntrianTanggal;
use App\Models\MTaskList;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MLogs;
use App\Models\MPeserta;
use App\Models\MReferensiPoli;
use App\Models\MReferensiDokter;
use App\Models\MJadwalDokter;
use App\Models\MBaymanagement;
use App\Models\MQueueList;
use App\Models\MSEPSelisih;

use DateTime;
use DateInterval;

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

    public function getTask6(Request $request)
    {
        $data = MTaskList::where('kodebooking', $request->kodebooking)
                        ->where('taskid', $request->caritask)
                        ->get();
        
        return response()->json($data);
    }

    public function getAntrean(Request $request)
    {
        $data = MAntrianTanggal::where('kodebooking', $request->kodebooking)
                        ->get();
        //dd($data);
        return response()->json($data);

    }

    public function getSelisih(Request $request)
    {
        $data = MSEPSelisih::where('kodebooking', $request->kodebooking)
                        ->with('peserta')
                        ->get();
        return response()->json($data);

    }
    public function postTask(Request $request)
    {
        $kodebooking = $request->input('kodebooking');
        $taskid = $request->input('taskid');
        $newTime = $request->input('newTime');

        // dd($kodebooking, $taskid, $newTime);
        $dataAntrian = $this->updateWkatu($kodebooking, $taskid, $newTime);
        return response()->json($dataAntrian);
    }
    public function postAddAntrean(Request $request)
    {
        $kodebooking = $request->input('kodebooking');
        $nokartu = $request->input('nokartu');
        $nik = $request->input('nik');
        $nohp = $request->input('nohp');
        $kodepoli = $request->input('kodepoli');
        $namapoli = $request->input('namapoli');
        $nomr = $request->input('nomr');
        $tanggal = $request->input('tanggal');
        $kddpjp = $request->input('kddpjp');
        $nmdpjp = $request->input('nmdpjp');
        $jadwal = $request->input('jadwal');
        $norujukan = $request->input('norujukan');
        $nomorantrian = $request->input('nomorantrian');
        $newTime = $request->input('newTime');
        $sisa = $request->input('sisa');
        $kapasitas = $request->input('kapasitas');
        
        // dd($kodebooking, $taskid, $newTime);
        $dataAntrian = $this->addAntrean(
            $kodebooking,
            $nokartu,
            $nik,
            $nohp,
            $kodepoli,
            $namapoli,
            $nomr,
            $tanggal,
            $kddpjp,
            $nmdpjp,
            $jadwal,
            $norujukan,
            $nomorantrian,
            $newTime,
            $sisa,
            $kapasitas
        );
        return response()->json($dataAntrian);
    }

    protected function updateWkatu($kodebooking, $taskid, $newTime)
    {

        $data = [
            'kodebooking' => $kodebooking,
            'taskid' => $taskid,
            'waktu' => $newTime
        ];

        
        $dataRequest = json_encode($data);

        $endpoint = 'antrean/updatewaktu';
        echo $kodebooking.'<br>';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        //dd($requestBridge);
        // Cek apakah respons tidak null
        if ($requestBridge == null) {
            dd($requestBridge, $data);
        }

        // Decode JSON response
        $result = json_decode($requestBridge);

        // Cek apakah result valid dan berisi metadata
        if (!isset($result->metadata)) {
            dd($result, $data);
        }
        $result = json_decode($requestBridge);
        
        $metadata = $result->metadata ?? null;
        if ($metadata) {
            $code = $metadata->code?? null;
            $message = $metadata->message ?? null;

            $pesan = $kodebooking;
            $pesan2 = "" ;

            $this->storeLogs($code, $message, $pesan, $pesan2);

        } else {
            $this->storeLogs('Unknown', 'No metadata in response', 'Response: ' . $requestBridge, 'Failed to fetch valid response. Kode Booking: '.$kodebooking. ' Task: '.$taskid);
        }

        return $result;
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
        return $result;

    }

    public function batalAntrean(Request $request)
    {
        $kodebooking = $request->input('kodebooking');
        $data = [
            'kodebooking' => $kodebooking,
            "keterangan"=> "Penggantian Jadwal HFIS"
        ];

        $dataRequest = json_encode($data);

        $endpoint = 'antrean/batal';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        $result = json_decode($requestBridge);
        // echo $result;
        // return $result;
        return response()->json($result);
    }


    protected function addAntrean(
        $kodebooking,
        $nomorkartu,
        $nik,
        $nohp,
        $kodepoli,
        $namapoli,
        $norm,
        $tanggal,
        $kodedokter,
        $namadokter,
        $jadwal,
        $nomorreferensi,
        $queue_no,
        $nomorantrian,
        $estimasidilayani,
        $sisakapasitas,
        $kapasitas
    )
    {
        $data = [
            "kodebooking" => $kodebooking,
            "jenispasien" => "JKN",
            "nomorkartu" => $nomorkartu,
            "nik" => $nik,
            "nohp" => $nohp,
            "kodepoli" => $kodepoli,
            "namapoli" => $namapoli,
            "pasienbaru" => 0,
            "norm" => $norm,
            "tanggalperiksa" => $tanggal,
            "kodedokter" => $kodedokter,
            "namadokter" => $namadokter,
            "jampraktek" => $jadwal,
            "jeniskunjungan" => 2,
            "nomorreferensi" => $nomorreferensi,
            "nomorantrean" => $queue_no,
            "angkaantrean" => $nomorantrian,
            "estimasidilayani" => $estimasidilayani,
            "sisakuotajkn" => $sisakapasitas,
            "kuotajkn" => $kapasitas,
            "sisakuotanonjkn" => 1,
            "kuotanonjkn" => 1,
            "keterangan"=> "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
        ];

        $dataRequest = json_encode($data);

        $endpoint = 'antrean/add';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        $result = json_decode($requestBridge);
        $metadata = $result->metadata ?? null;

        $pesan = $kodebooking;
        $pesan2 = " " ;
        $api = "Add Antrean";

        $code = $metadata->code?? null;
        $message = $metadata->message ?? null;
        $this->storeLogsAlter($api, $code, $message, $pesan, $pesan2);

        if ($metadata) {
            $code = $metadata->code?? null;
            $message = $metadata->message ?? null;

           
            $this->storeLogsAlter($api, $code, $message, $pesan, $pesan2);
            // if ($code == 200)
            // {
            //     $this->flagaddantrean($norm, $tanggal);
            // }
            
        } else {
            $this->storeLogs('Unknown', 'No metadata in response', 'Response: ' . $requestBridge, 'Failed to fetch valid response. Kode Booking: '.$kodebooking. ' Task: '.$taskid);
        }

        // FLAG ANTREAN AGAR TIDAK DI KIRIM OLEH SISTEM
        // $this->flagaddantrean($norm, $tanggal);
        
        // dd($data, $result, $code);
        
        return $result;
    }

    // protected function addAntreanManual(
        
    // )
    // {

    // }

    public function autoUpdateTask()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = "2026-01-06";
        echo $tanggal;
        // MENGAMBIL DATA ANTRIAN YANG STATUS NYA BELUM DILAYANI
        $data = MAntrianTanggal::where('tanggal', $tanggal)
                        ->whereIn('status', ["Belum dilayani", "Sedang dilayani"])
                        ->whereHas('tasklist')
                        ->with('tasklist')
                        ->get();
        
        foreach($data as $item)
        {
            // DIAMBIL KODEBOOKING NYA
            $kodebooking [] = $item->kodebooking;
        }
        //dd($kodebooking);
        
        // PROSES PERULANGAN BERDASARKAN KODEBOOKING YANG SUDAH DITARIK
        for($i=0; $i < COUNT($kodebooking); $i++)
        {
            // MENGAMBIL TASKLIST 1 BARIS DIMANA TASKID TERAKHIR
            $taskData = MTaskList::where('kodebooking', $kodebooking[$i])
                    ->orderBy('taskid', 'DESC')
                    ->first();

            $kodeBooking = $taskData->kodebooking;
            $taskid = $taskData->taskid;
            $waktuRs = $taskData->wakturs;
            $waktu2 = substr($waktuRs, 0, 19);
            $postTaskid = $taskid + 1;
            // dd($taskData, $kodeBooking, $taskid, $waktuRs, $waktu2, $postTaskid);

            // PENGECEKAN JIKA TASKID NYA SUDAH 5 99 ATAU 0 MAKA AKAN DI SKIP
            if ($taskid >= 5 || $taskid == 99 || $taskid == 0) {
                continue;
            }
            

            $newTime = $this->pembagianWaktu($waktu2, $postTaskid);

            // MELAKUKAN POST TASK MENGGUNAKAN METODE REQUEST MENGIKUTI SCRIP DARI
            // FUNCTION POST TASK
            $request = new Request();
            $request->replace([
                'kodebooking' => $kodeBooking,
                'taskid' => $postTaskid,
                'newTime' => $newTime
            ]);

            $response = $this->postTask($request);
            $responseData = $response->getData(); 

            $code = $responseData->metadata->code ?? $responseData->code ?? null;
            $message = $responseData->metadata->message ?? $responseData->message ?? null;

            //dd($responseData);
            echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
            echo $pesan2 = "Proses Post Task Kodebooking" . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
            //$this->storeLogs($code, $message, $pesan, $pesan2);
            
            // HASIL NYA AKAN DILAKUKAN PENGECEKAN MANUAL BERDASARKAN TANGGAL DAN KODEBOOKING
            // LALU AKAN DISIMPAN UNTUK UPDATE TASKID TERAKHIR DARI KODEBOOKING TERSEBUT
            $storeRequest = new Request();
            $storeRequest->replace([
                'kodebooking' => $kodeBooking,
                'tanggal' => $tanggal
            ]);

            $storeResponse = $this->store($storeRequest);
            $storeResponseData = $storeResponse->getData();
            
            $code = $storeResponseData->metadata->code ?? $storeResponseData->code ?? null;
            $message = $storeResponseData->metadata->message ?? $storeResponseData->message ?? null;

            echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
            echo $pesan2 = "Update Data Task Lokal Database " . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
        }
        echo $tanggal;

        //return redirect()->route('updatetask.digitalclock');

    }

    public function autoUpdateTask7()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = "20205-12-30";
        // MENGAMBIL DATA ANTRIAN YANG STATUS NYA BELUM DILAYANI
        $data = MAntrianTanggal::where('tanggal', $tanggal)
                        ->where('status', "Selesai dilayani")
                        ->whereHas('tasklist')
                        ->with('tasklist')
                        ->get();
        
        foreach($data as $item)
        {
            // DIAMBIL KODEBOOKING NYA
            $kodebooking [] = $item->kodebooking;
        }
        //dd($kodebooking);
        
        // PROSES PERULANGAN BERDASARKAN KODEBOOKING YANG SUDAH DITARIK
        for($i=0; $i < COUNT($kodebooking); $i++)
        {
            // MENGAMBIL TASKLIST 1 BARIS DIMANA TASKID TERAKHIR
            $kd = '36688565';
            $taskData = MTaskList::where('kodebooking', $kodebooking[$i])
                    ->where('taskid', 6)
                    ->orderBy('taskid', 'DESC')
                    ->first();
            // dd($taskData);
            // PENGECEKAN JIKA $taskData kosong maka akan di skip ke $kodebooking[$i]
            if ($taskData === null)
            {
                continue;
            }

            $kodeBooking = $taskData->kodebooking;
            $taskid = $taskData->taskid;
            $waktuRs = $taskData->wakturs;
            $waktu2 = substr($waktuRs, 0, 19);
            $postTaskid = $taskid + 1;
            // dd($taskData, $kodeBooking, $taskid, $waktuRs, $waktu2, $postTaskid);
            

            $newTime = $this->pembagianWaktu($waktu2, $postTaskid);

            // MELAKUKAN POST TASK MENGGUNAKAN METODE REQUEST MENGIKUTI SCRIP DARI
            // FUNCTION POST TASK
            $request = new Request();
            $request->replace([
                'kodebooking' => $kodeBooking,
                'taskid' => $postTaskid,
                'newTime' => $newTime
            ]);

            $response = $this->postTask($request);
            $responseData = $response->getData(); 
            // dd($response);

            $code = $responseData->metadata->code ?? $responseData->code ?? null;
            $message = $responseData->metadata->message ?? $responseData->message ?? null;

            //dd($responseData);
            echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
            echo $pesan2 = "Proses Post Task Kodebooking" . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
            //$this->storeLogs($code, $message, $pesan, $pesan2);
            
            // HASIL NYA AKAN DILAKUKAN PENGECEKAN MANUAL BERDASARKAN TANGGAL DAN KODEBOOKING
            // LALU AKAN DISIMPAN UNTUK UPDATE TASKID TERAKHIR DARI KODEBOOKING TERSEBUT
            $storeRequest = new Request();
            $storeRequest->replace([
                'kodebooking' => $kodeBooking,
                'tanggal' => $tanggal
            ]);

            $storeResponse = $this->store($storeRequest);
            $storeResponseData = $storeResponse->getData();
            
            $code = $storeResponseData->metadata->code ?? $storeResponseData->code ?? null;
            $message = $storeResponseData->metadata->message ?? $storeResponseData->message ?? null;

            echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
            echo $pesan2 = "Update Data Task Lokal Database " . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
        }

        //return redirect()->route('updatetask.digitalclock');

    }

    public function autoUpdateTaskError()
    {   
        $tanggal = DATE('Y-m-d');
        // $tanggal = "2025-01-17";
        $data = MLogs::select('message', 'data')
                ->whereDate('created_at', $tanggal)
                ->where('message', 'LIKE', '%TaskId sebelumnya belum terkirim%')
                ->groupBy('message', 'data') // Tambahkan 'message' ke dalam GROUP BY
                ->get();

        foreach($data as $item)
        {
            // DIAMBIL KODEBOOKING NYA
            $kodebooking [] = $item->data;
        }
        
        for($i=0; $i < COUNT($kodebooking); $i++)
        {
            // HAPUS SPASI DI DALAM KODEBOOKING
            $kodebookingTrimmed = trim($kodebooking[$i]);

            $taskData = MTaskList::where('kodebooking', $kodebookingTrimmed)
                    ->orderBy('taskid', 'DESC')
                    ->first();
            
            // DATA TO VARIABEL
            $kodeBooking = $taskData->kodebooking;
            $taskid = $taskData->taskid;
            $waktuRs = $taskData->wakturs;
            $waktu2 = substr($waktuRs, 0, 19);
            // dd($taskData, $kodeBooking);

            if ($taskid >= 5 || $taskid == 99 || $taskid == 0) {
                continue;
            }

            $randomTime = $this->getRandomTime(1, 2);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);

            $request = new Request();
            $request->replace([
                'kodebooking' => $kodeBooking,
                'taskid' => $taskid,
                'newTime' => $newTime
            ]);
            // dd($request);
            // POST DATA KE BPJS
            $response = $this->postTask($request);
            $responseData = $response->getData(); 

            $storeRequest = new Request();
            $storeRequest->replace([
                'kodebooking' => $kodeBooking,
                'tanggal' => $tanggal
            ]);
            
            // HASIL NYA AKAN DILAKUKAN PENGECEKAN MANUAL BERDASARKAN TANGGAL DAN KODEBOOKING
            // LALU AKAN DISIMPAN UNTUK UPDATE TASKID TERAKHIR DARI KODEBOOKING TERSEBUT
            $storeResponse = $this->store($storeRequest);
            $storeResponseData = $storeResponse->getData();
        }
    }



    public function prosesUpdate($kodeBooking, $tanggal)
    {
        $taskData = MTaskList::where('kodebooking', $kodeBooking)
                    ->orderBy('taskid', 'DESC')
                    ->first();
        //dd($taskData, $kodebooking);
        $kodeBooking = $taskData->kodebooking;
        $taskid = $taskData->taskid;
        $waktuRs = $taskData->wakturs;
        $waktu2 = substr($waktuRs, 0, 19);
        $postTaskid = $taskid + 1;
        
        $newTime = $this->pembagianWaktu($waktu2, $postTaskid);
        // dd($waktu2, $newTime);
        // dd([
        //     'kodebooking' => $kodeBooking,
        //     'taskid' => $taskid,
        //     'wakturs' => $waktuRs
        // ], $waktu2, $newTime, $postTaskid);

        $request = new Request();
        $request->replace([
            'kodebooking' => $kodeBooking,
            'taskid' => $postTaskid,
            'newTime' => $newTime
        ]);

        $response = $this->postTask($request);
        $responseData = $response->getData(); 

        $code = $responseData->metadata->code ?? $responseData->code ?? null;
        $message = $responseData->metadata->message ?? $responseData->message ?? null;

        // dd([
        //     'kodebooking' => $kodeBooking,
        //     'taskid' => $taskid,
        //     'wakturs' => $waktuRs
        // ], $waktu2, $newTime, $postTaskid, $response, $responseData);
        //dd($responseData);
        echo $pesan = $kodeBooking;
        echo $pesan2 = "";
        $this->storeLogs($code, $message, $pesan, $pesan2);
        
        $storeRequest = new Request();
        $storeRequest->replace([
            'kodebooking' => $kodeBooking,
            'tanggal' => $tanggal
        ]);

        $storeResponse = $this->store($storeRequest);
        $storeResponseData = $storeResponse->getData();
        
        $code = $storeResponseData->metadata->code ?? $storeResponseData->code ?? null;
        $message = $storeResponseData->metadata->message ?? $storeResponseData->message ?? null;

        echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
        echo $pesan2 = "Update Data Task Lokal Database " . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
        // dd([
        //     'kodebooking' => $kodeBooking,
        //     'taskid' => $taskid,
        //     'wakturs' => $waktuRs
        // ], $waktu2, $newTime, $postTaskid, $response, $responseData, $storeResponseData);

        //$this->storeLogs($code, $message, $pesan, $pesan2);
        // die();
    }

    public function pembagianWaktu($waktu2, $taskid)
    {
        if ($taskid == 2) {
            $randomTime = $this->getRandomTime(1, 3);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        } elseif ($taskid == 3) {
            $randomTime = $this->getRandomTime(2, 4);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        } elseif ($taskid == 4) {
            $randomTime = $this->getRandomTime(20, 45);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        } elseif ($taskid == 5) {
            $randomTime = $this->getRandomTime(5, 10);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        } elseif ($taskid == 6) {
            $randomTime = $this->getRandomTime(3, 6);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        } elseif ($taskid == 7) {
            $randomTime = $this->getRandomTime(7, 15);
            $newTime = $this->addMillisecondsToTimestamp($waktu2, $randomTime);
            return $newTime;
        }

        return null; // Jika taskid tidak sesuai
    }

    public function getRandomTime($minMinutes, $maxMinutes)
    {
        $minMs = $minMinutes * 60 * 1000; // Mengubah menit ke milisecond
        $maxMs = $maxMinutes * 60 * 1000; // Mengubah menit ke milisecond
        return rand($minMs, $maxMs); // Menggunakan rand() untuk mengambil nilai acak
    }

    public function convertTimestampToDate($timestamp)
    {
        // Memisahkan tanggal dan waktu
        $parts = explode(' ', $timestamp);
        $datePart = $parts[0]; // Tanggal
        $timePart = $parts[1]; // Waktu

        // Memisahkan hari, bulan, tahun
        $dateComponents = explode('-', $datePart);
        $day = $dateComponents[0];
        $month = $dateComponents[1];
        $year = $dateComponents[2];

        // Memisahkan jam, menit, detik
        $timeComponents = explode(':', $timePart);
        $hour = $timeComponents[0];
        $minute = $timeComponents[1];
        $second = $timeComponents[2];

        // Membuat objek DateTime
        return new DateTime("$year-$month-$day $hour:$minute:$second");
    }

    function convertToMilliseconds($waktuRs) {
        // Mengonversi string waktuRs ke objek DateTime
        $timezone = new \DateTimeZone('Asia/Jakarta');
        $dateTime = \DateTime::createFromFormat('d-m-Y H:i:s', $waktuRs, $timezone);
    
        if (!$dateTime) {
            throw new \Exception('Format waktu tidak valid');
        }
    
        // Menghitung milidetik dari tanggal
        $milliseconds = $dateTime->getTimestamp() * 1000; // Konversi detik ke milidetik
        return $milliseconds;
    }
    
    public function addMillisecondsToTimestamp($timestamp, $milliseconds)
    {

        $date = $this->convertToMilliseconds($timestamp);
        return $newtime = $date + $milliseconds;
        
    }

    public function storeLogs($code, $message, $pesan, $pesan2)
    {
        MLogs::create([
            'metode'        => 'POST',
            'api'           => 'Update Task',
            'controller'    => 'UpdateTaskController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan.' '. $pesan2,
            'created_at'    => DATE('Y-m-d h:m:s'),
            'updated_at'    => DATE('Y-m-d h:m:s')

        ]);
    }

    public function storeLogsAlter($api, $code, $message, $pesan, $pesan2)
    {
        MLogs::create([
            'metode'        => 'POST',
            'api'           => $api,
            'controller'    => 'UpdateTaskController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan.' '. $pesan2,
            'created_at'    => DATE('Y-m-d h:m:s'),
            'updated_at'    => DATE('Y-m-d h:m:s')

        ]);
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
        return view('bpjs.update-task.digitalclock');
    }

    public function autoAddTask()
    {
        // MENGAMBIL DATA MTASKLIST BERDASARKAN TANGGAL DAN TASKID = 0
        $tanggal = DATE('Y-m-d');
        // $tanggal = "2026-01-06";
        $data = MTaskList::where('tanggal_data', $tanggal)
                        ->where('taskid', "0")
                        ->with('antrian') 
                        ->get();
        
        // FETCH DATA
        foreach($data as $item)
        {
            $kodebooking []         = $item->kodebooking;
            $estimasidilayani []    = $item->antrian->estimasidilayani;
        }

        for($i = 0; $i <= COUNT($kodebooking); $i++)
        {
            $randomTime = $this->getRandomTime(8, 10);
            $newTime = $estimasidilayani[$i] + $randomTime;

            $request = new Request();
            $request->replace([
                'kodebooking' => $kodebooking[$i],
                'taskid' => 3,
                'newTime' => $newTime
            ]);
            // dd($kodebooking[$i], $newTime, $estimasidilayani[$i], $request);

            $response = $this->postTask($request);
            $responseData = $response->getData(); 

            $storeRequest = new Request();
            $storeRequest->replace([
                'kodebooking' => $kodebooking[$i],
                'tanggal' => $tanggal
            ]);

            $storeResponse = $this->store($storeRequest);
            $storeResponseData = $storeResponse->getData();
            //dd($kodebooking[$i], $newTime, $estimasidilayani[$i], $responseData, $storeResponseData);
            echo $kodebooking[$i]. '<br>';
        }

    }

    public function autoAddAntrean()
    {
        $tanggal = DATE('Y-m-d');
        // dd($tanggal);
        $tanggal_estimasi = DATE('d-m-Y');
        // $tanggal = DATE('2025-01-17');
        // $tanggal_estimasi = DATE('17-01-2025');
        $waktuestimasi = [];
        $jumlahdata = [];
        
        $data = MSEPSelisih::where('tglsep', $tanggal)
                        ->where('poli', '<>', 'INSTALASI GAWAT DARURAT')
                        ->where('flagaddantrean', 'f')
                        ->with('peserta')
                        // ->limit('10')
                        ->get();

        // FETECH DATA DARI MSEPSELISIH
        $nomor = rand(1,1000);
        //dd($data);
        foreach ($data as $item)
        {
            $nokartu[] = $item->nokartu;
            $nomr[] = $item->nomr;
            $poli[] = $item->poli;
            $nama[] = $item->nama;
            $kddpjp[] = $item->kddpjp;
            $nmdpjp[] = $item->nmdpjp;
            $norujukan[] = $item->norujukan;
            $kodebooking[] = $item->kodebooking;

            foreach ($item->peserta as $peserta) {
                $nohp[] = $peserta->noTelepon; 
                $nik[] =$peserta->nik;
            }

            
        }
        // dd($kodebooking);
        // GET JADWAL POLI
        for($i=0; $i<COUNT($kddpjp); $i++)
        {
            $dataJadwal = $this->getJadwalDokter($kddpjp[$i], $tanggal, $nomr[$i]);

            if ($dataJadwal) {  
                $kodedokter[] = $dataJadwal['kodedokter'];
                $jadwal[] = $dataJadwal['jadwal'];
                $kapasitas[] = $dataJadwal['kapasitas'];
            }

        }
        // dd($poli);
        // GET KODE POLI
        for($i=0; $i<COUNT($poli); $i++)
        {
            $dataPoli = $this->getPoli($poli[$i]);
            
            if ($dataPoli) {  
                $kodepoli[] = $dataPoli['kodepoli'];
                $namapoli[] = $dataPoli['namapoli'];
            }

        }

        // GET ANTRIAN POLI
        for($i=0; $i<COUNT($nomr); $i++)
        {
            // $dataAntrian = $this->getAntrianPoli($nomr[$i], $tanggal);
            $dataAntrian = $this->getQueueList($nomr[$i], $tanggal);

            if ($dataAntrian) {  
                $nomorantrian[] = abs($dataAntrian['nomorantrian']);
                $queue_no[] = $dataAntrian['queue_no'];
                // $selesaikonsul[] = $dataAntrian['selesaikonsul'];
            }

        }

        // MANIPULASI NOMOR ANTRIAN
        for($i=0; $i<COUNT($kapasitas); $i++)
        {
            if($nomorantrian[$i] > $kapasitas[$i])
            {
                $kapasitasJkn = $kapasitas[$i] - 1;
                $nomorantrian[$i] = rand(1, $kapasitasJkn);
            }
            continue;
        }

        // MEMBUAT ESTIMASI
        for($i=0; $i<COUNT($jadwal); $i++)
        {
            $subJadwal = substr($jadwal[$i], 0, 5);
            $waktuestimasi[] = $tanggal_estimasi.' '.$subJadwal.':00';
            $randomTime = $this->getRandomTime(4, 30);
            //dd($waktuestimasi, $randomTime);
            $newTime[$i] = $this->addMillisecondsToTimestamp($waktuestimasi[$i], $randomTime);

        }

        for($i=0; $i<COUNT($nmdpjp); $i++)
        {
            // $hasil = $this->getKapasitasDokter($nmdpjp, $tanggal);
            // $jumlahdata[$i] = $hasil['jumlahdata'];
            $kapasitas2 = $kapasitas[$i] - 1;
            $sisa[] = rand(1, $kapasitas2);
        }



        for($i=0; $i<COUNT($nokartu); $i++)
        {

            // dd($nokartu[$i], $queue_no[$i], $nomorantrian[$i]);
            $data = $this->addAntrean(
                $kodebooking[$i], 
                $nokartu[$i], 
                $nik[$i],
                $nohp[$i],
                $kodepoli[$i],
                $poli[$i],
                $nomr[$i],
                $tanggal,
                $kddpjp[$i],
                $nmdpjp[$i],
                $jadwal[$i],
                $norujukan[$i],
                $queue_no[$i],
                $nomorantrian[$i],
                $newTime[$i],
                $sisa[$i],
                $kapasitas[$i]
            );
        echo response()->json($data);
        echo $kodebooking[$i].'<br>';

        
        }
        

    }

    public function generateKodebooking()
    {
        $kode = rand(36,37);
        $tanggal = DATE('Ymd');
        $template = $kode.''.$tanggal;
        
        return $template;
    }
    
    public function getPeserta($nomorkartu)
    {
        $data = MPeserta::where('noKartu', $nomorkartu)->get();
        foreach($data as $item)
        {
            $nik = $item->nik;
        }
        //dd($data,$nomorkartu, $nik);

        return $nik;
    }

    public function getPoli($namapoli)
    {
        $data = MReferensiPoli::where('nmpoli', $namapoli)->first();
        
        // Jika tidak ditemukan, cari berdasarkan nmsubspesialis
        if (!$data) {
            $data = MReferensiPoli::where('nmsubspesialis', $namapoli)->first();
        }

        // Jika tetap tidak ditemukan, kembalikan null atau pesan error
        if (!$data) {
            return null; // atau bisa gunakan return ['error' => 'Poli not found'];
        }

        return [
            'kodepoli' => $data->kdpoli,
            'namapoli' => $data->nmpoli
        ];
    }

    public function getPoliklinik(Request $request)
    {
        $data = MReferensiPoli::where('nmpoli', $request->namapoli)->first();
        
        // Jika tidak ditemukan, cari berdasarkan nmsubspesialis
        if (!$data) {
            $data = MReferensiPoli::where('nmsubspesialis', $request->namapoli)->first();
        }

        // Jika tetap tidak ditemukan, kembalikan null atau pesan error
        if (!$data) {
            return null; // atau bisa gunakan return ['error' => 'Poli not found'];
        }

        return [
            'kodepoli' => $data->kdpoli,
            'namapoli' => $data->nmpoli
        ];
    }

    public function getDokter($kodedokter)
    {
        $data = MReferensiDokter::where('kodedokter', $kodedokter)->get();
        foreach($data as $item)
        {
            $namadokter = $item->namadokter;
        }
        
        return $namadokter;
    }

    public function getJadwalDokter($kodedokter, $tanggal, $nomr)
    {
        $data = MJadwalDokter::where('kodedokter', $kodedokter)
                            ->where('tanggal_data', $tanggal)
                            ->first();
        // if(!$data)
        // {
        //     dd($kodedokter, $nomr);
        // }
        // dd($kodedokter);
        return [
            'kodedokter' => $data->kodedokter,
            'jadwal' => $data->jadwal,
            'kapasitas' => $data->kapasitaspasien,
        ];
    }

    public function getJadwalDokterPoli(Request $request)
    {
        $data = MJadwalDokter::where('kodedokter', $request->kddpjp)
                                ->where('tanggal_data', $request->tanggal)
                                ->first();

        return [
            'kodedokter' => $data->kodedokter,
            'jadwal' => $data->jadwal,
            'kapasitas' => $data->kapasitaspasien,
        ];
    }

    public function getAntrianPoli($norm, $tanggal)
    {
        $data = MBaymanagement::where('norm', $norm)
                            ->where('tanggal_data', $tanggal)
                            ->first();
        // dd($data);
        if (!$data) {
            $data = new \stdClass();
            $data->nomorantrian = null;
            $data->mulaikonsul = null;
            $data->selesaikonsul = null;
        }

        if (is_null($data->nomorantrian)) {
            $data->nomorantrian = rand(1, 10);
        }

        return [
            'nomorantrian' => $data->nomorantrian,
            'mulaikonsul' => $data->mulaikonsul,
            'selesaikonsul' => $data->selesaikonsul
        ];

    }

    public function getQueueList($norm, $tanggal)
    {
        $data = MQueueList::where('medical_record_no', $norm)
                           ->whereDate('date', $tanggal)
                           ->first();
        if (!$data) {
            $data = new \stdClass();
            $data->no = null;
            $data->queue_no = null;
        }

        if (is_null($data->queue_no)) {
            $data->no = rand(1, 10);
            $data->queue_no = $data->no;
        }

        return [
            'nomorantrian' => $data->no,
            'queue_no' => $data->queue_no
        ];

    }

    public function getAntrianPoliklinik(Request $request)
    {
        $data = MBaymanagement::where('norm', $request->nomr)
                            ->where('tanggal_data', $request->tanggal)
                            ->first();

        return [
            'nomorantrian' => $data->nomorantrian,
            'mulaikonsul' => $data->mulaikonsul,
            'selesaikonsul' => $data->selesaikonsul
        ];

    }

    public function getKapasitasDokter($nmdpjp, $tanggal)
    {
        $data = MBaymanagement::where('dokter', 'LIKE', '%dr. '.$nmdpjp.'%')
                            ->where('tanggal_data', $tanggal)
                            ->tosql();
        //dd($data);
        return [
            'jumlahdata' => $data
        ];

    }

    public function flagaddantrean($nomr, $tanggal)
    {
        // UPDATE FLAG TRUE ADD ANTREAN
        MSEPSelisih::where('nomr', $nomr)
                    ->where('tglsep', $tanggal)
                    ->update(['flagaddantrean' => true]);
    }

}
