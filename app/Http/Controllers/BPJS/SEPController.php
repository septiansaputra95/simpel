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
        // $tanggal = DATE('2024-12-17');
        
        // JENIS LAYANAN 1 = RAWAT INAP, 2 = RAWAT JALAN
        $jenislayanan = 2;
        $kunjungan = $this->kunjungan($tanggal, $jenislayanan);
        $responseKunjungan = $kunjungan->response;
        //$nomor = DATE('Ymd');
        $nomor = DATE('20241008');
        
        //dd($tanggal, $jenislayanan, $responseKunjungan->sep);

        // DELETE DATA SEBELUM SIMPAN UNTUK MEMPERBARUI
        MVclaimSEP::where('nomor', $nomor)->delete();
        
        if (is_array($responseKunjungan->sep)) {
            foreach ($responseKunjungan->sep as $item) {
                MVclaimSEP::create([
                    'nomor'          => $nomor,
                    'nomor_sep'      => $item->noSep,
                    'nomor_rujukan'  => $item->noRujukan,
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
        // $tanggal = DATE('2024-12-17');
        echo $tanggal;
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
                    'nomr'          => $responseSEP->peserta->noMr,
                    'kddpjp'        => $responseSEP->dpjp->kdDPJP,
                    'nmdpjp'        => $responseSEP->dpjp->nmDPJP
                ]);

                echo 'Simpan SEP: '. $nosep[$i]. '<br>';
                // dd($responseSEP);
            } else {
                echo "No SEP :". $nosep[$i]. ' Sudah Ada <br>';
            }
        } 
    }

    public function autoSelisih()
    {
        // $tanggal = DATE('Y-m-d');
        $tanggal = DATE('2024-12-17');

        /* The line `//  = DATE('Y-m-d');` is a commented-out line in PHP code. This means that
        this line is not currently active or executed when the code runs. It is used to assign the
        current date in the format 'Y-m-d' to the variable ``. */
        // $tanggal = DATE('2024-12-04');
        

        MSEPSelisih::where('tglsep', $tanggal)->delete();

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
                      'm_s_e_p_s.nomr',
                      'm_s_e_p_s.kddpjp',
                      'm_s_e_p_s.nmdpjp'

                  )
                  ->get();
         
        foreach($result as $item)
        {
            $nomor = RAND(1,100);
            $template = $this->generateKodebooking();
            $kodebooking = $template.''.$nomor;
            MSEPSelisih::create([
                'nosep'         => $item->nosep,
                'tglsep'        => $item->tglsep,
                'kelasrawat'    => $item->kelasrawat,
                'diagnosa'      => $item->diagnosa,
                'kodebooking'   => $kodebooking,
                'norujukan'     => $item->norujukan,
                'poli'          => $item->poli,
                'nokartu'       => $item->nokartu,
                'nama'          => $item->nama,
                'nomr'          => $item->nomr,
                'kddpjp'        => $item->kddpjp,
                'nmdpjp'        => $item->nmdpjp
            ]);
            // $nomor++;
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

    public function generateKodebooking()
    {
        $kode = rand(36,40);
        $tanggal = DATE('md');
        $template = $kode.'24'.$tanggal;
        
        return $template;
    }

    public function cariselisih()
    {
        $tanggal = DATE('Y-m-d');
        // $tanggal = '2024-12-04';
        echo $tanggal.'<br>';
        $data = MSEP::where('tglsep', $tanggal)
                ->where('poli', '<>', 'INSTALASI GAWAT DARURAT')->get();

        $dataAntrian = MAntrianTanggal::where('tanggal', $tanggal)->get();

        foreach($data as $item)
        {
            // DIAMBIL KODEBOOKING NYA
            $nosep[] = $item->nosep;
            $tglsep[] = $item->tglsep;
            $kelasrawat[] = $item->kelasrawat;
            $diagnosa[] = $item->diagnosa;
            $norujukan[] = $item->norujukan;
            $poli[] = $item->poli;
            $nokartu [] = $item->nokartu;
            $nama[] = $item->nama;
            $nomr[] = $item->nomr;
            $kddpjp[] = $item->kddpjp;
            $nmdpjp[] = $item->nmdpjp;
        }

        foreach($dataAntrian as $itemAntrian)
        {
            // DIAMBIL KODEBOOKING NYA
            $nokapst [] = $itemAntrian->nokapst;
            $norekammedis[] = $itemAntrian->norekammedis;
        }
        //dd($nama);
        // for($i=0; $i > COUNT($nokartu); $i++)
        // {
        //     for($j=0; $j = COUNT($nokapst); $j++)
        //     {
        //         if($nokartu[$i] <> $nokapst[$j])
        //         {
        //             echo $nokartu[$i].'<br>';
        //         }
        //     }
        // }
        $nomorin = 1;
        MSEPSelisih::where('tglsep', $tanggal)->delete();
        // Bandingkan setiap nokartu dengan semua nokapst
        foreach ($nomr as $index => $nomrValue) {
            $found = false;
    
            // Periksa apakah nomr ada di norekammedis
            foreach ($norekammedis as $rekamMedis) {
                if ($nomrValue == $rekamMedis) {
                    $found = true; // Jika ditemukan kecocokan
                    break;
                }
            }
    
            // Jika tidak ditemukan kecocokan, tampilkan nomr dan nama yang sesuai
            if (!$found) {

                $nomor = RAND(1,9999);
                $template = $this->generateKodebooking();
                $kodebooking = $template.''.$nomor;
                MSEPSelisih::create([
                    'nosep'         => $nosep[$index],
                    'tglsep'        => $tglsep[$index],
                    'kelasrawat'    => $kelasrawat[$index],
                    'diagnosa'      => $diagnosa[$index],
                    'kodebooking'   => $kodebooking,
                    'norujukan'     => $norujukan[$index],
                    'poli'          => $poli[$index],
                    'nokartu'       => $nokartu[$index],
                    'nama'          => $nama[$index],
                    'nomr'          => $nomr[$index],
                    'kddpjp'        => $kddpjp[$index],
                    'nmdpjp'        => $nmdpjp[$index]
                ]);

                echo $nomorin.'. '.$nomrValue . ' - ' . $nama[$index] . ' - ' . $nokartu[$index] . '- ' . $nosep[$index] .'<br>';
                $nomorin++;
            }
        }

        // foreach ($nokartu as $index => $nokartuValue) {
        //     $found = false;
    
        //     // Periksa apakah nokartu ada di nokapst
        //     foreach ($nokapst as $kapst) {
        //         if ($nokartuValue == $kapst) {
        //             $found = true; // Jika ditemukan kecocokan
        //             break;
        //         }
        //     }
    
        //     // Jika tidak ditemukan kecocokan, tampilkan nokartu dan nama yang sesuai
        //     if (!$found) {
        //     echo $nomor.'. '.$nomrValue . ' - ' . $nama[$index] . ' - ' . $nokartu[$index] . ' - ' . $nosep[$index] .'<br>';
        //         $nomor++; // Tambahkan nomor urut
        //     }
        // }

        
    }
}
