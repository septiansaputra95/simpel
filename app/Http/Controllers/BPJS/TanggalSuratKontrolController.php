<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bpjs\Bridging\Vclaim\BridgeVclaim;
use App\Models\MTanggalSuratKontrol;
use App\Models\MAppointmentDetail;
use Illuminate\Support\Facades\DB;

class TanggalSuratKontrolController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeVclaim;
    }
    
    public function index()
    {
        //
        set_time_limit(300); // 5 menit
        ini_set('max_execution_time', 300); // 5 menit

        $data = DB::table('m_appointment_details as a')
            ->join('m_pesertas as p', 'a.no_mrn', '=', 'p.noMr')  // p.noMr bukan p.noMrn
            ->where('a.unit_name', 'NOT LIKE', '%Eksekutif%')
            ->select('a.*', 'p.*')
            ->get();

        foreach($data as $item) {
            // echo "MRN: " . $item->no_mrn . "<br>";
            // echo "Nama Patient: " . $item->patient_name . "<br>";
            // echo "Nama Peserta: " . $item->nama . "<br>";
            // echo "No Kartu: " . $item->noKartu . "<br>";
            // echo "Unit: " . $item->unit_name . "<br>";
            // echo "Tanggal: " . $item->tanggal_data . "<br>";
            // echo "----------------------------------------<br>";
            // $surkon = $this->carisurkon('10', '2025', '0001699028188', '2');
            // dd($surkon);

            foreach($data as $item) {
                echo "MRN: " . $item->no_mrn . "<br>";
                echo "Nama Peserta: " . $item->nama . "<br>";
                echo "No Kartu: " . $item->noKartu . "<br>";

                $surkon = $this->carisurkon('10', '2025', $item->noKartu, '2');
                
                // Cek jika response berhasil
                if ($surkon->response && isset($surkon->response->list)) {
                    $this->insertSuratKontrol($surkon->response->list, $item);
                } else {
                    echo "Tidak ada data surat kontrol<br>";
                }
                
                echo "----------------------------------------<br>";
            }
        }

        // dd("Total data: " . $data->count());

        // dd(
        //     "Jumlah data: " . $data->count(),
        //     "Data pertama: " . $data->first(),
        //     "Semua data: " . $data
        // );
        // return $data;


    }

    protected function carisurkon($bulan, $tahun, $nokartu, $param4)
    {
        // $endpoint = "Peserta/nokartu/{$nokartu}/tglSEP/{$tanggal}";
        $endpoint = "RencanaKontrol/ListRencanaKontrol/Bulan/{$bulan}/Tahun/{$tahun}/Nokartu/{$nokartu}/filter/{$param4}";
        $requestBridge = $this->bridging->getRequest($endpoint);
        $result = json_decode($requestBridge);
        return $result;
    }

    protected function insertSuratKontrol($listData, $peserta)
    {
        // Jika data multiple (array)
        if (is_array($listData)) {
            foreach ($listData as $data) {
                $this->simpanDataSuratKontrol($data, $peserta);
            }
        } else {
            // Jika data single (object)
            $this->simpanDataSuratKontrol($listData, $peserta);
        }
    }

    protected function simpanDataSuratKontrol($data, $peserta)
    {
        try {
            MTanggalSuratKontrol::create([
                'nosuratkontrol' => $data->noSuratKontrol ?? null,
                'jenispelayanan' => $data->jnsPelayanan ?? null,
                'jeniskontrol' => $data->jnsKontrol ?? null,
                'namajeniskontrol' => $data->namaJnsKontrol ?? null,
                'tglrencanankontrol' => $data->tglRencanaKontrol ?? null,
                'tglterbitkontrol' => $data->tglTerbitKontrol ?? null,
                'nosepasalkontrol' => $data->noSepAsalKontrol ?? null,
                'poliasal' => $data->poliAsal ?? null,
                'namapoliasal' => $data->namaPoliAsal ?? null,
                'politujuan' => $data->poliTujuan ?? null,
                'namapolitujuan' => $data->namaPoliTujuan ?? null,
                'tglsep' => $data->tglSEP ?? null,
                'kodedokter' => $data->kodeDokter ?? null,
                'namadokter' => $data->namaDokter ?? null,
                'nokartu' => $data->noKartu ?? $peserta->noKartu,
                'nama' => $data->nama ?? $peserta->nama,
                'terbitsep' => $data->terbitSEP ?? null,
            ]);

            echo "✅ Data surat kontrol berhasil disimpan: " . ($data->noSuratKontrol ?? 'N/A') . "<br>";
            echo "   - Nama: " . ($data->nama ?? $peserta->nama) . "<br>";
            echo "   - Tgl Rencana: " . ($data->tglRencanaKontrol ?? 'N/A') . "<br>";
            echo "   - Poli Tujuan: " . ($data->namaPoliTujuan ?? 'N/A') . "<br>";
            
        } catch (\Exception $e) {
            echo "❌ Gagal menyimpan data: " . $e->getMessage() . "<br>";
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
