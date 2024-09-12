<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\MPeserta;
use App\Models\MAntrianTanggal;

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
        $tanggal = DATE('Y-m-d');
        $hitung = 0;
        $dataAntrian = MAntrianTanggal::where('tanggal', $tanggal)
                ->get();
        foreach($dataAntrian as $data) {
            $nokapst = $data->nokapst;
            $pesertaData = $this->peserta($nokapst, $tanggal);

            $peserta = $pesertaData->response->peserta;
            
            $existingPeserta = MPeserta::where('nik', $peserta->nik)->first();

            if (!$existingPeserta) {
                MPeserta::create([
                    'nik' => $peserta->nik,
                    'nama' => $peserta->nama,
                    'noKartu' => $peserta->noKartu,
                    'pisa' => $peserta->pisa,
                    'kdprovider' => $peserta->provUmum->kdProvider,
                    'nmprovider' => $peserta->provUmum->nmProvider,
                    'kodekelas' => $peserta->hakKelas->kode,
                    'kelas' => $peserta->hakKelas->keterangan,
                    'statuspesertakode' => $peserta->statusPeserta->kode,
                    'statuspesertaketerangan' => $peserta->statusPeserta->keterangan,
                    'jenispesertakode' => $peserta->jenisPeserta->kode,
                    'jenispesertaketerangan' => $peserta->jenisPeserta->keterangan
                ]);
                echo "Peserta: " . $peserta->nama . " Berhasil Disimpan";
                $hitung++;
            } else {
                echo "Peserta: " . $peserta->nama . " Sudah Ada";
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

}
