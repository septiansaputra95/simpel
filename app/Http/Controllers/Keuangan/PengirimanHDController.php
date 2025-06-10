<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Mail\Events\MessageFailed;
use App\Models\MPengirimanHonorDokter;
use App\Models\MLogsEmailHD;
use App\Models\MMasterDokter;
use App\Models\MFileHonorDokter;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Google_Service_Gmail_Draft;
use Google_Service_Gmail_MessagePart;
use Google_Service_Gmail_MessagePartHeader;


class PengirimanHDController extends Controller
{
    //
    private $emailFailed = false;

    public function __construct()
    {
        Event::listen(MessageFailed::class, function () {
            $this->emailFailed = true;
        });
    }

    public function index()
    {
        return view('keuangan.honordokter.index'); 
    }

    public function loadDatatables(Request $request)
    {
        $tanggalawal = $request->input('tanggal');

        if(is_null($tanggalawal))
        {
            $tanggalawal = $this->getDataTerbaru();

        } else {

        }
        $data =  MPengirimanHonorDokter::where('tanggalawal', $tanggalawal)
                                            ->with('dokter')
                                            ->get();
        // dd($data);
        
        $no = 1;
            foreach($data as $item) {
                $query[] = [
                    'no' => $no++,
                    'kodedokter' => $item->kodedokter,
                    'namadokter' => $item->dokter->namadokter,
                    'tanggalawal' => $item->tanggalawal,
                    'tanggalakhir' => $item->tanggalakhir,
                    'flagkirim' => $item->flagkirim ? 'Sudah Kirim' : 'Belum Kirim',
                    'flagkirim_checkbox' => $item->flagkirim ? '' : '<input class="form-check-input" type="checkbox" name="checkbox_' . $item->id . '" value="' . $item->id . '">',
                ];
            }
        // dd($query);
        $result = isset($query) ? ['data' => $query] : ['data' => 0];
        return response()->json($result);
        
    }

    public function getDataTerbaru()
    {
        $data = MPengirimanHonorDokter::orderByDesc('tanggalawal')
                                        ->first();
        
        if($data)
        {
            // return $data;
            return $data->tanggalawal;
        }
        return null;
    }
    public function getDokter(Request $request)
    {
        $data = MMasterDokter::get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        // dd($request->file()); // FILE sudah masuk ke store

        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $dokter = $request->input('dokter');

        $filePaths = [];
        // $lastData = MPengirimanHonorDokter::orderBy('id', 'DESC')->first();
        // $lastId = $lastData ? $lastData->id + 1 : 1;
        $files = $request->file('file1');
        $uploadedFiles = $request->allFiles();
        
        MPengirimanHonorDokter::create([
            'kodedokter' => $dokter,
            'tanggalawal' => $tanggal_awal,
            'tanggalakhir' => $tanggal_akhir,
            'file' => null,
            'flagkirim' => false
        ]);

        $lastData = MPengirimanHonorDokter::orderBy('id', 'DESC')->first();
        $lastId = $lastData->id;

        // Simpan file ke folder private
        foreach ($uploadedFiles as $file) {
            $path = $file->store("uploads", 'private');
        
            MFileHonorDokter::create([
                'idpengiriman' => $lastId,
                'kodedokter' => $dokter,
                'file' => $path,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data dan file berhasil disimpan',
            'file_paths' => $filePaths
        ]);


        // =============================

        // $filePaths = [];

        // try{
        //     $no = 0;
        //     if($request->hasFile('file1'))
        //     {
        //         $lastData = MPengirimanHonorDokter::orderBy('id', 'DESC')->first();

        //         if ($lastData) {
        //             $lastId = $lastData->id + 1;
        //         } else {
        //             $lastId = 1;
        //         }
        //         // dd($file, $filePath,  $request);
        //         MPengirimanHonorDokter::create([
        //             'kodedokter' => $request->dokter,
        //             'tanggalawal' => $request->tanggal_awal,
        //             'tanggalakhir' => $request->tanggal_akhir,
        //             'file' => null,
        //             'flagkirim' => false
        //         ]);

        //         foreach ($filePaths as $filePath) {
        //             MFileHonorDokter::create([
        //                 'idpengiriman' => $lastId,
        //                 'kodedokter' => $request->dokter,
        //                 'file' => $filePath,
        //             ]);
        //         }
                

        //         return response()->json([
        //             'status' => 'success',
        //             'message' => 'Data Berhasil Disimpan',
        //             'file_path' => $filePath
        //         ], 200);
        //     }

        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'File tidak ditemukan'
        //     ], 400);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Terjadi kesalahan saat menyimpan data',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }

    public function send(Request $request)
    {
        $selectedId = $request->input('selectedId');

        if (!$selectedId || !is_array($selectedId)) {
            return response()->json(['message' => 'Tidak Ada Data Yang Di Kirim'], 400);
        }

        $successCount = 0;
        $errorCount = 0;

        foreach($selectedId as $id)
        {
            $data = MPengirimanHonorDokter::with('dokter')->find($id);

            if (!$data || !$data->dokter) {
                $errorCount++;
                continue;
            }

            // dd($data->dokter->namadokter);
            // dd($data);
            $result = $this->email(
                $data->dokter->namadokter,
                $data->dokter->emaildokter,
                $data->tanggalawal,
                $data->tanggalakhir,
                $data->id
            );
            
            if ($result) {
                $successCount++;
                $this->logsKirim($data, true);
            } else {
                $errorCount++;
                $this->logsKirim($data, false);
            }
            
            // UPDATE FLAG KIRIM
            $resultUpdate = $this->updateKirim(
                $data->id
            );

        }

        return response()->json([
            'message' => 'Pengiriman email selesai',
            'success' => $successCount,
            'error' => $errorCount,
        ]);
    }

    public function logsKirim($data, $status)
    {
        MLogsEmailHD::create([
            'idpengiriman' => $data->id,
            'kodedokter' => $data->dokter->kodedokter,
            'emaildokter' => $data->dokter->emaildokter,
            'tanggalawal' => $data->tanggalawal,
            'tanggalakhir' => $data->tanggalakhir,
            'statuspengiriman' => $status
        ]);
    }

    public function updateKirim($id)
    {
        // dd($id);
        $data = MPengirimanHonorDokter::find($id);
        $data->flagkirim = true;
        $data->save();

    }

    public function email($namadokter, $emaildokter, $tanggalawal, $tanggalakhir, $id)
    {
        
        $subject = "Slip Honor Dokter Periode $tanggalawal - $tanggalakhir";

        $body = "
        Yth. $namadokter,\n
        di tempat\n
        Semoga Tuhan YME senantiasa melimpahkan rahmat-Nya kepada kita semua dalam menjalankan aktivitas kita sehari-hari dan semoga dokter selalu dalam keadaan sehat. Aamiin.
        Sehubungan dengan pembayaran Honor Dokter/Terapis Periode $tanggalawal - $tanggalakhir, berikut kami kirimkan Slip beserta lampirannya.\n
        Demikian yang kami sampaikan. Semoga dapat diterima dengan baik.
        Atas perhatiannya kami ucapkan terima kasih
        ";
        
        try {
            \Illuminate\Support\Facades\Mail::raw($body, function ($message) use ($emaildokter, $subject, $id) {
                $message->to($emaildokter)
                        ->subject($subject);
                        
                // if ($file) {
                //     $filePath = storage_path('app\\private\\' . str_replace('/', '\\', $file));
                //     // dd($filePath);
                //     if (file_exists($filePath)) {
                //         // Attach file only if it exists
                //         $message->attach($filePath);
                //     } else {
                //         // Log if the file is not found
                //         \Log::error("File tidak ditemukan di path: " . $filePath);
                //     }
                // }
                $files = $this->getFile($id);
                

                // Loop untuk setiap file dan attach ke email
                foreach ($files as $file) {
                    // dd($file->file);
                    $filePath = storage_path('app\\private\\' . str_replace('/', '\\', $file->file));
                    // dd($filePath);
                    if (file_exists($filePath)) {
                        // Attach file jika file ditemukan
                        $message->attach($filePath);
                    } else {
                        // Log jika file tidak ditemukan
                        \Log::error("File tidak ditemukan di path: " . $filePath);
                    }
                }
            });
            
            // return true; // Indikator sukses
            return !$this->emailFailed;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email: ' . $e->getMessage());
            return false; // Indikator gagal
        }
    }

    public function getFile($id)
    {
        $data = MFileHonorDokter::where('idpengiriman', $id)
                                ->get();
        return $data;
    }

    public function redirectToGoogle()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/credentials/credentials.json'));
        $client->addScope(\Google_Service_Gmail::GMAIL_SEND);

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl); // Arahkan pengguna ke URL otorisasi Google
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/credentials/credentials.json'));
        $client->addScope(\Google_Service_Gmail::GMAIL_SEND);

        // Tukarkan kode dengan token akses
        if ($request->has('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));

            if (isset($token['access_token'])) {
                // Simpan token ke session atau database
                session(['google_access_token' => $token]);
                return response()->json(['message' => 'Login berhasil, token telah disimpan.']);
            }
        }

        return response()->json(['message' => 'Gagal mendapatkan token.'], 400);
    }


    private function createMessage($namadokter, $emaildokter, $tanggalawal, $tanggalakhir, $file)
    {
        $subject = "Pengiriman Honor Dokter: $namadokter";
        $messageText = "Halo Dr. $namadokter,\n\nBerikut adalah detail honor:\nTanggal Awal: $tanggalawal\nTanggal Akhir: $tanggalakhir\nMohon untuk dapat dikoreksi jika terjadi kesalahan
        \n\nDemikian yang bisa kami sampaikan, Terima kasih.";

        $headers = [
            'To' => $emaildokter,
            'Subject' => $subject,
            'From' => 'your-email@gmail.com', // Ganti dengan alamat email Anda
            'Content-Type' => 'text/plain; charset=UTF-8',
        ];

        $mime = rtrim(strtr(base64_encode($messageText), '+/', '-_'), '=');

        $messagePart = new Google_Service_Gmail_MessagePart();
        $messagePart->setBody(['data' => $mime]);
        $messagePart->setHeaders([
            new Google_Service_Gmail_MessagePartHeader(['name' => 'Content-Type', 'value' => 'text/plain; charset=UTF-8']),
            new Google_Service_Gmail_MessagePartHeader(['name' => 'Content-Transfer-Encoding', 'value' => 'base64']),
        ]);

        $rawMessage = base64_encode("From: " . $headers['From'] . "\r\n" .
            "To: " . $headers['To'] . "\r\n" .
            "Subject: " . $headers['Subject'] . "\r\n" .
            "Content-Type: " . $headers['Content-Type'] . "\r\n\r\n" . $messageText);

        return $rawMessage;
    }

    private function getAccessToken()
    {
        // Cek di storage, apakah access token sudah ada
        // Anda bisa menyimpan access token dan refresh token di database atau session
        return session('google_access_token');
    }

    private function storeAccessToken($accessToken)
    {
        // Simpan token ke storage atau session
        session(['google_access_token' => $accessToken]);
    }
}
