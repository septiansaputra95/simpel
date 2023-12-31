<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RepoPoliklinik;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $repoPoli;

    public function __construct()
    {
        $this->repoPoli   = new RepoPoliklinik;
    }

    public function index()
    {
        //
        return view('farmasikonsumsi.index');
    }

    public function antrian()
    {
        //
        $data = $this->repoPoli->getDataDokter();
        //dd($data);
        return view('poliklinik.antrian', ['data'=> $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function cetak(Request $request)
    {
        //
        $data = [
            'dokter' => $request->input('dokter'),
            'poliklinik' => $request->input('poliklinik'),
            'nomorAntrian' => $request->input('nomorAntrian'),
            'formattedDate' => $request->input('formattedDate'),
        ];
        return view('poliklinik.cetak', ['data' => $data]);
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
