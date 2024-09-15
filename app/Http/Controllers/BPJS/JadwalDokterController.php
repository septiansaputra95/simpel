<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Antrol\BridgeAntrol;
use App\Models\MReferensiPoli;
use App\Models\MJadwalDokter;
use App\Models\MLogs;



class JadwalDokterController extends Controller
{
    //
    // ANTREAN PER TANGGAL
    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeAntrol;
    }

    public function index()
    {
        $tanggal = DATE('Y-m-d');

        $poli = MReferensiPoli::select('kdpoli')
                ->groupBy('kdpoli')
                ->orderBy('kdpoli', 'ASC')
                ->get();

        foreach($poli as $item)
        {
            $jadwal = $this->jadwaldokter($item->kdpoli, $tanggal);
            
            if($jadwal->metadata->code == 200)
            {
                $code = $jadwal->metadata->code;
                $message = $jadwal->metadata->message;
                $this->store($jadwal, $tanggal);
                echo $pesan = "Data berhasil disimpan untuk poli: " . $item->kdpoli . " ".$item->nmpoli."<br>";
                $this->storeLogs($code, $message, $pesan);
            } 
            elseif ($jadwal->metadata->code == 1)
            {
                $code = $jadwal->metadata->code;
                $message = $jadwal->metadata->message;
                echo  $pesan = "Tidak ada data untuk poli: " . $item->kdpoli . " ".$item->nmpoli."<br>";
                $this->storeLogs($code, $message, $pesan);
                continue;
            }
            //die();
        }
        
    }

    protected function jadwaldokter($poli, $tanggal)
    {
        //dd($poli, $tanggal);
        $endpoint = "jadwaldokter/kodepoli/{$poli}/tanggal/{$tanggal}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }

    public function store($jadwal, $tanggal)
    {   
        //dd($tanggal);
        foreach($jadwal->response as $dokter)
        {
            MJadwalDokter::create([
                'kodesubspesialis'  => $dokter->kodesubspesialis,
                'hari'              => $dokter->hari,
                'kapasitaspasien'   => $dokter->kapasitaspasien,
                'libur'             => $dokter->libur,
                'namahari'          => $dokter->namahari,
                'jadwal'            => $dokter->jadwal,
                'namasubspesialis'  => $dokter->namasubspesialis,
                'namadokter'        => $dokter->namadokter,
                'kodepoli'          => $dokter->kodepoli,
                'namapoli'          => $dokter->namapoli,
                'kodedokter'        => $dokter->kodedokter,
                'tanggal_data'      => $tanggal
            ]);
        }
    }

    public function digitalClock()
    {
        return view('bpjs.jadwaldokter.digitalclock');
    }

    public function storeLogs($code, $message, $pesan)
    {
        MLogs::create([
            'metode'        => 'GET',
            'api'           => 'Jadwal Dokter',
            'controller'    => 'JadwalDokterController',
            'code'          => $code,
            'message'       => $message,
            'data'          => $pesan
        ]);
    }

}
