<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\MLogs;
use App\Models\MSEP;
use App\Models\MVclaimSEP;
use App\Models\MBaymanagement;
use App\Models\MAntrianTanggal;
use App\Models\MSEPSelisih;


class SEPController extends Controller
{
    //

    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }
    public function autoStoreKunjungan()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = DATE('2024-10-02');
        
        // JENIS LAYANAN 1 = RAWAT INAP, 2 = RAWAT JALAN
        $jenislayanan = 2;
        $kunjungan = $this->kunjungan($tanggal, $jenislayanan);
        $responseKunjungan = $kunjungan->response;
        $nomor = DATE('Ymd');
        
        //dd($tanggal, $jenislayanan, $responseKunjungan->sep);

        // DELETE DATA SEBELUM SIMPAN UNTUK MEMPERBARUI
        MVclaimSEP::where('nomor', $nomor)->delete();
        
        if (is_array($responseKunjungan->sep)) {
            foreach ($responseKunjungan->sep as $item) {
                MVclaimSEP::create([
                    'nomor'          => $nomor,
                    'nomor_sep'      => $item->noSep,
                    'tanggal_sep'    => $item->tglSep,
                    'rirj'           => $item->jnsPelayanan,
                    'nomor_kartu'    => $item->noKartu,
                    'nama_peserta'   => $item->nama,
                    'diagnosa'       => $item->diagnosa,
                    'poli'           => $item->poli
                ]);
            }
        } else {
            echo "Response kunjungan tidak berbentuk array.";
        }
        
        echo "Selesai Mining Kunjungan ". $tanggal;

    }
    public function autoStore()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = DATE('2024-10-02');

        $data = MVclaimSEP::where('tanggal_sep', $tanggal)->get();
        
        foreach($data as $item)
        {
            $nosep[]        = $item->nomor_sep;
            
        }
        
        MSEP::where('tglsep', $tanggal)->delete();

        for($i = 0; $i < COUNT($nosep); $i++)
        {
            $SEPData = $this->sep($nosep[$i]);
            $responseSEP = $SEPData->response;
            // dd($responseSEP);

            $existingPeserta = MSEP::where('nosep', $nosep[$i])->first();

            if (!$existingPeserta) {
                MSEP::create([
                    'nosep'         => $responseSEP->noSep,
                    'tglsep'        => $responseSEP->tglSep,
                    'kelasrawat'    => $responseSEP->kelasRawat,
                    'diagnosa'      => $responseSEP->diagnosa,
                    'norujukan'     => $responseSEP->noRujukan,
                    'poli'          => $responseSEP->poli,
                    'nokartu'       => $responseSEP->peserta->noKartu,
                    'nama'          => $responseSEP->peserta->nama,
                    'nomr'          => $responseSEP->peserta->noMr
                ]);

                echo 'Simpan SEP: '. $nosep[$i]. '<br>';
            } else {
                echo "No SEP :". $nosep[$i]. ' Sudah Ada <br>';
            }
        } 
    }

    public function autoSelisih()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = DATE('2024-10-02');

        $result = MSEP::leftJoin('m_antrian_tanggals', 'm_s_e_p_s.nomr', '=', 'm_antrian_tanggals.norekammedis')
                  ->whereNull('m_antrian_tanggals.norekammedis')
                  ->where('m_s_e_p_s.tglsep', $tanggal)
                  ->select(
                      'm_s_e_p_s.nosep', 
                      'm_s_e_p_s.tglsep', 
                      'm_s_e_p_s.kelasrawat', 
                      'm_s_e_p_s.diagnosa', 
                      'm_s_e_p_s.norujukan', 
                      'm_s_e_p_s.poli', 
                      'm_s_e_p_s.nokartu', 
                      'm_s_e_p_s.nama', 
                      'm_s_e_p_s.nomr'
                  )
                  ->get();
 
        foreach($result as $item)
        {
            MSEPSelisih::create([
                'nosep'         => $item->nosep,
                'tglsep'        => $item->tglsep,
                'kelasrawat'    => $item->kelasrawat,
                'diagnosa'      => $item->diagnosa,
                'norujukan'     => $item->norujukan,
                'poli'          => $item->poli,
                'nokartu'       => $item->nokartu,
                'nama'          => $item->nama,
                'nomr'          => $item->nomr
            ]);
            echo "Nama: ". $item->nama. ' NoMR: '.$item->nomr. ' Berhasil disimpan <br>';
        }
    }

    protected function sep($nosep)
    {
        $endpoint = "SEP/{$nosep}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);

        $metadata = $result->metadata ?? null;
        if ($metadata) {
            $code = $metadata->code?? null;
            $message = $metadata->message ?? null;

            $pesan = $nosep;
            $pesan2 = " " ;

            $this->storeLogs($code, $message, $pesan, $pesan2);

        } else {
            $this->storeLogs('Unknown', 'No metadata in response', 'Response: ' . $requestBridge, 'Failed to save data '.$nosep);
        }

        return $result;
    }

    protected function kunjungan($tanggal, $jenislayanan)
    {
        $endpoint = "Monitoring/Kunjungan/Tanggal/{$tanggal}/JnsPelayanan/{$jenislayanan}";
        
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);

        return $result;
    }

    public function storeLogs($code, $message, $pesan, $pesan2)
    {
        MLogs::create([
            'metode'        => 'GET',
            'api'           => 'SEP',
            'controller'    => 'SEPController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan.' '. $pesan2,
            'created_at'    => DATE('Y-m-d h:m:s'),
            'updated_at'    => DATE('Y-m-d h:m:s')

        ]);
    }
}
