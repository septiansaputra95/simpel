<?php

namespace App\Http\Controllers\BPJS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MBaymanagement;

class BaymanagementController extends Controller
{
    //
    public function index()
    {
        $url = 'https://reporting.herminahospitals.com/live/birtreports?_reportFormat=json&fromDate=11-09-2024+00%3A00&toDate=11-09-2024+23%3A59&branchId=54400&branchName=RS+HERMINA+PEKALONGAN&deptId=&deptName=&unitId=&unitName=&consultantId=&consultantName=&asscmpnyId=&asscmpnyName=&ReportName=Bay+Management+Report&ReportFileName=Bay_Management_Report.rptdesign&ReportPath=reports%2Fhis%2FBay_Management_Report.jsf'; // URL lengkap

        // Melakukan permintaan GET
        $response = Http::get($url);

        // Memeriksa jika permintaan berhasil
        if ($response->successful()) {
            $htmlContent = $response->body(); // Mendapatkan isi dari respons
            
            // Memeriksa isi HTML yang diterima
            dd($htmlContent);

            $this->parseAndStoreReportData($htmlContent);
        } else {
            // Tangani jika permintaan gagal
            return response()->json([
                'code' => $response->status(),
                'message' => 'Gagal mengambil data.',
            ], $response->status());
        }
    }
}
