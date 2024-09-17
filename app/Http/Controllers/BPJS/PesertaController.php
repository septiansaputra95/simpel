<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\MPeserta;
use App\Models\MAntrianTanggal;
use App\Models\MLogs;


class PesertaController extends Controller
{
    //
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }

    public function index()
    {
        //$tanggal = DATE('Y-m-d');
        $tanggal = "2024-09-14";

        $hitung = 0;
        $dataAntrian = MAntrianTanggal::where('tanggal', $tanggal)
                ->get();
        foreach($dataAntrian as $data) {
            $nokapst        = $data->nokapst;
            $pesertaData    = $this->peserta($nokapst, $tanggal);
            $peserta        = $pesertaData->response->peserta;
            $metaData       = $pesertaData->metaData;
            $code           = $metaData->code;
            $message        = $metaData->message;

            
            
            $existingPeserta = MPeserta::where('nik', $peserta->nik)->first();

            if (!$existingPeserta) {
                MPeserta::create([
                    'nik'                       => $peserta->nik,
                    'nama'                      => $peserta->nama,
                    'noKartu'                   => $peserta->noKartu,
                    'pisa'                      => $peserta->pisa,
                    'kdprovider'                => $peserta->provUmum->kdProvider,
                    'nmprovider'                => $peserta->provUmum->nmProvider,
                    'kodekelas'                 => $peserta->hakKelas->kode,
                    'kelas'                     => $peserta->hakKelas->keterangan,
                    'statuspesertakode'         => $peserta->statusPeserta->kode,
                    'statuspesertaketerangan'   => $peserta->statusPeserta->keterangan,
                    'jenispesertakode'          => $peserta->jenisPeserta->kode,
                    'jenispesertaketerangan'    => $peserta->jenisPeserta->keterangan
                ]);
                echo $pesan = "Peserta: " . $peserta->nik . " ". $peserta->nama ." Berhasil Disimpan";
                
                MLogs::create([
                    'metode'        => 'GET',
                    'api'           => 'Peserta by No Kartu',
                    'controller'    => 'PesertaController',
                    'code'          => $code,
                    'message'       => $message,
                    'data'          => $pesan
                ]);

                $hitung++;
            } else {
                echo $pesan = "Peserta: ". $peserta->nik . " ". $peserta->nama ." Sudah Ada";
                MLogs::create([
                    'metode'        => 'GET',
                    'api'           => 'Peserta by No Kartu',
                    'controller'    => 'PesertaController',
                    'code'          => $code,
                    'message'       => $message,
                    'data'          => $pesan
                ]);
            }

            echo "<br>";
        }
        echo $hitung. " Berhasil Disimpan";
    }

    protected function peserta($nokartu, $tanggal)
    {
        $endpoint = "Peserta/nokartu/{$nokartu}/tglSEP/{$tanggal}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }

    public function digitalClock()
    {
        return view('bpjs.peserta.digitalclock');
    }

}
