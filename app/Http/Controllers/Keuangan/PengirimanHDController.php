<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\MPengirimanHonorDokter;
use App\Models\MMasterDokter;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Google_Service_Gmail_Draft;
use Google_Service_Gmail_MessagePart;
use Google_Service_Gmail_MessagePartHeader;

class PengirimanHDController extends Controller
{
    //
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
        // $data = MPengirimanHonorDokter::with('dokter')
        //                                 ->latest('tanggalawal')
        //                                 ->get();
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

        // return [
        //     'kodedokter' => $data->kodedokter,
        //     'namadokter' => $data->namadokter
        // ];
        // dd($data);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        try{
            // dd($request->tanggal_awal, $request->tanggal_akhir, $request->dokter, $request->nama_file);
            if($request->hasFile('file'))
            {
                $file = $request->file('file');

                if ($file->getClientMimeType() !== 'application/pdf') {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File harus berupa PDF'
                    ], 422);
                }

                $filePath = $file->store('uploads', 'private');
                
                // dd($file, $filePath,  $request);
                MPengirimanHonorDokter::create([
                    'kodedokter' => $request->dokter,
                    'tanggalawal' => $request->tanggal_awal,
                    'tanggalakhir' => $request->tanggal_akhir,
                    'file' => $filePath,
                    'flagkirim' => false
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Berhasil Disimpan',
                    'file_path' => $filePath
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'File tidak ditemukan'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function send(Request $request)
    {
        $selectedId = $request->input('selectedId');
        // dd($selectedId);

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
                $data->file
            );
            
            if ($result) {
                $successCount++;
            } else {
                $errorCount++;
            }

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

    public function updateKirim($id)
    {
        // dd($id);
        $data = MPengirimanHonorDokter::find($id);
        $data->flagkirim = true;
        $data->save();

    }

    public function email($namadokter, $emaildokter, $tanggalawal, $tanggalakhir, $file)
    {
        
        $subject = "Laporan Honor Dokter";
        $body = "
        Halo, $namadokter,\n
        Semoga Anda dalam keadaan sehat selalu. Kami ingin menginformasikan bahwa honor Anda untuk periode [$tanggalawal] hingga [$tanggalakhir] telah kami proses dan kirimkan.\n
        Mohon untuk memeriksa dan memastikan bahwa semua detail yang tercantum sudah benar. Jika ada pertanyaan atau ketidakcocokan, jangan ragu untuk menghubungi kami segera.\n
        Terima kasih atas dedikasi dan kerja keras Anda.\n
        Salam hormat,
        ";
        
        try {
            \Illuminate\Support\Facades\Mail::raw($body, function ($message) use ($emaildokter, $subject, $file) {
                $message->to($emaildokter)
                        ->subject($subject);
                        
                if ($file) {
                    $filePath = storage_path('app\\private\\' . str_replace('/', '\\', $file));
                    // dd($filePath);
                    if (file_exists($filePath)) {
                        // Attach file only if it exists
                        $message->attach($filePath);
                    } else {
                        // Log if the file is not found
                        \Log::error("File tidak ditemukan di path: " . $filePath);
                    }
                }
            });
            
            return true; // Indikator sukses
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email: ' . $e->getMessage());
            return false; // Indikator gagal
        }

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
