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
    public function postTask(Request $request)
    {
        $kodebooking = $request->input('kodebooking');
        $taskid = $request->input('taskid');
        $newTime = $request->input('newTime');

        // dd($kodebooking, $taskid, $newTime);
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

        
        $dataRequest = json_encode($data);

        $endpoint = 'antrean/updatewaktu';
        echo $kodebooking.'<br>';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        //dd($requestBridge);
        // Cek apakah respons tidak null
        if ($requestBridge === null) {
            return redirect()->route('updatetask.digitalclock');
        }

        // Decode JSON response
        $result = json_decode($requestBridge);

        // Cek apakah result valid dan berisi metadata
        if (!isset($result->metadata)) {
            return redirect()->route('updatetask.digitalclock');
        }
        $result = json_decode($requestBridge);
        
        $metadata = $result->metadata ?? null;
        if ($metadata) {
            $code = $metadata->code?? null;
            $message = $metadata->message ?? null;

            $pesan = $kodebooking;
            $pesan2 = " " ;

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

    protected function batalAntrean($kodebooking)
    {
        $data = [
            'kodebooking' => $kodebooking,
            "keterangan"=> "Batal Antrean"
        ];

        $dataRequest = json_encode($data);

        $endpoint = 'antrean/batal';
        $requestBridge = $this->bridging->postRequest($endpoint, $dataRequest);
        $result = json_decode($requestBridge);
        return $result;
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
            "norm" => $kodebooking,
            "kodebooking" => $norm,
            "tanggalperiksa" => $tanggal,
            "kodedokter" => $kodedokter,
            "namadokter" => $namadokter,
            "jampraktek" => $jadwal,
            "jeniskunjungan" => 1,
            "nomorreferensi" => $nomorreferensi,
            "nomorantrean" => $nomorantrian,
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
        if ($metadata) {
            $code = $metadata->code?? null;
            $message = $metadata->message ?? null;

            $pesan = $kodebooking;
            $pesan2 = " " ;

            $this->storeLogs($code, $message, $pesan, $pesan2);

        } else {
            $this->storeLogs('Unknown', 'No metadata in response', 'Response: ' . $requestBridge, 'Failed to fetch valid response. Kode Booking: '.$kodebooking. ' Task: '.$taskid);
        }
        
        return $result;
    }

    public function autoUpdateTask()
    {
        $tanggal = DATE('Y-m-d');
        //$tanggal = "2024-09-18";
        $data = MAntrianTanggal::where('tanggal', $tanggal)
                        ->where('status', "Belum dilayani")
                        ->whereHas('tasklist')
                        ->with('tasklist')
                        ->get();
        
        foreach($data as $item)
        {
            $kodebooking [] = $item->kodebooking;
        }
        //dd($kodebooking);
        
        for($i=0; $i < COUNT($kodebooking); $i++)
        {
            $taskData = MTaskList::where('kodebooking', $kodebooking[$i])
                    ->orderBy('taskid', 'DESC')
                    ->first();
            //dd($taskData, $kodebooking);
            $kodeBooking = $taskData->kodebooking;
            $taskid = $taskData->taskid;
            $waktuRs = $taskData->wakturs;
            $waktu2 = substr($waktuRs, 0, 19);
            $postTaskid = $taskid + 1;
            // dd($taskData, $kodeBooking, $taskid, $waktuRs, $waktu2, $postTaskid);

            if ($taskid >= 5 || $taskid == 99 || $taskid == 0) {
                continue;
            }
            
            // $prosesUlang = 5 - $taskid;
            // dd($taskid, $prosesUlang);
            // for($j=1; $j = $prosesUlang; $j++)
            // {
            //     $this->prosesUpdate($kodeBooking, $tanggal);
            //     echo $j;
            // }  

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
            echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
            echo $pesan2 = "Proses Post Task Kodebooking" . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
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

        return redirect()->route('updatetask.digitalclock');

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
        echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
        echo $pesan2 = "Proses Post Task Kodebooking" . $kodeBooking . " Task id " . $postTaskid .". Selesai.";
        //$this->storeLogs($code, $message, $pesan, $pesan2);
        
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
        // Konversi timestamp ke objek DateTime
        // $date = $this->convertTimestampToDate($timestamp);
        $date = $this->convertToMilliseconds($timestamp);
        return $newtime = $date + $milliseconds;
        //dd($date, $timestamp, $milliseconds, $newtime);

        // Tambahkan milidetik (mengubahnya menjadi detik untuk PHP DateInterval)
        // $interval = new DateInterval('PT' . ($milliseconds / 1000) . 'S');
        // $date->add($interval);

        // Mengembalikan waktu yang telah diubah dalam format 'Y-m-d H:i:s'
        // return $date->format('Y-m-d H:i:s');
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
        //$tanggal = "2024-09-18";
        $data = MTaskList::where('tanggal_data', $tanggal)
                        ->where('taskid', "0")
                        ->with('antrian') 
                        ->get();

        // FETCH DATA
        foreach($data as $item)
        {
            $kodebooking []         = $item->kodebooking;
            $nomorkartu []          = $item->antrian->nokapst;
            $norm []                = $item->antrian->norekammedis;
            $nohp []                = $item->antrian->nohp;
            $kodepoli []            = $item->antrian->kodepoli;
            $kodedokter []          = $item->antrian->kodedokter;
            $estimasidilayani []    = $item->antrian->estimasidilayani;
            $nomorreferensi []      = $item->antrian->nomorreferensi;

        }
        // dd($kodebooking, $nomorkartu, $norm, $nohp, $kodepoli, $kodedokter);
        // MENGAMBIL DATA YANG DIPERLUKAN
        for($i = 0; $i<COUNT($kodebooking); $i++)
        {   
            $rm = '1330043893';
            $nik            = $this->getPeserta($nomorkartu[$i]);
            $namapoli       = $this->getPoli($kodepoli[$i]);
            $namadokter     = $this->getDokter($kodedokter[$i]);
            $hasil          = $this->getJadwalDokter($kodedokter[$i], $tanggal);
            $nomorantrian   = $this->getAntrianPoli($norm[$i].'.0', $tanggal);

            
            //$nomorantrian = $this->getAntrianPoli($rm.'.0', $tanggal);
            // MENGHILANGKAN .0 DALAM NOMOR ANTRIAN BUG DARI MINING PYTHON
            $nomorantrian = str_replace('.0', '', $nomorantrian);
            
            // JADWAL DAN KAPASITAS DI DEKLARASI KAN DALAM VARIABEL BERBEDA
            $jadwal         = $hasil['jadwal'];
            $kapasitas      = $hasil['kapasitas'];

            // DEKLARASI SISA KAPASITAS KUOTA JKN
            //dd($nomorantrian, $norm[$i]);
        
            
            if($nomorantrian == '')
            {
                $batal = $this->batalAntrean($kodebooking[$i]);
                
                $storeRequest = new Request();
                $storeRequest->replace([
                    'kodebooking' => $kodebooking[$i],
                    'tanggal' => $tanggal
                ]);

                $storeResponse = $this->store($storeRequest);
                $storeResponseData = $storeResponse->getData();
                
                $code = $storeResponseData->metadata->code ?? $storeResponseData->code ?? null;
                $message = $storeResponseData->metadata->message ?? $storeResponseData->message ?? null;

                echo $pesan = "Pesan: " . $message . " ". $code. "<br>";
                echo $pesan2 = "Batal Antrean " . $kodebooking[$i] . " Task id";
                $this->storeLogs($code, $message, $pesan, $pesan2);
                //dd($batal);
                continue;
            }

            $sisakapasitas   = $kapasitas - $nomorantrian;
            //dd($kodebooking[$i], $nomorantrian, $norm[$i], $sisakapasitas);
            $addAntrean = $this->addAntrean(
                $kodebooking[$i],
                $nomorkartu[$i],
                $nik,
                $nohp[$i],
                $kodepoli[$i],
                $namapoli,
                $norm[$i],
                $tanggal,
                $kodedokter[$i],
                $namadokter,
                $jadwal,
                $nomorreferensi[$i],
                $nomorantrian,
                $estimasidilayani[$i],
                $sisakapasitas,
                $kapasitas

            );
            //dd($addAntrean, $norm[$i], $kodepoli[$i], $namapoli, $kodedokter[$i], $namadokter, $jadwal, $kapasitas, $nomorantrian, $sisakapasitas);
        }
        return redirect()->route('updatetask.digitalclock');
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

    public function getPoli($kodepoli)
    {
        $data = MReferensiPoli::where('kdpoli', $kodepoli)->get();
        foreach($data as $item)
        {
            $namapoli = $item->nmpoli;
        }
        
        return $namapoli;
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

    public function getJadwalDokter($kodedokter, $tanggal)
    {
        $data = MJadwalDokter::where('kodedokter', $kodedokter)
                            ->where('tanggal_data', $tanggal)
                            ->get();

        foreach($data as $item)
        {
            $jadwal = $item->jadwal;
            $kapasitas = $item->kapasitaspasien;
        }
        
        return [
            'jadwal' => $jadwal,
            'kapasitas' => $kapasitas,
        ];
    }

    public function getAntrianPoli($norm, $tanggal)
    {
        $data = MBaymanagement::where('norm', $norm)
                            ->where('tanggal_data', $tanggal)
                            ->get();
        $nomorantrian ='';
        foreach($data as $item)
        {
            $nomorantrian = $item->nomorantrian;
        }
        
        return $nomorantrian;
    }

}
