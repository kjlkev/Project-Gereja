<?php

namespace App\Http\Controllers;

use App\Models\Ibadah;
use App\Models\Pengajaran;
use Illuminate\Http\Request;

class JadwalPengajaranController extends Controller
{
    public function index()
    {
        $pengajarans = Pengajaran::all();
        return view('daftar-pengajaran.index', compact('pengajarans'));
    }

    public function getIbadahSchedule($id)
    {
        // Fetch the Ibadah schedule based on the provided ID
        $ibadahSchedule = Ibadah::find($id);

        if (!$ibadahSchedule) {
            return response()->json(['error' => 'Ibadah not found'], 404);
        }

        return response()->json($ibadahSchedule);
    }

    public function create(Request $request)
    {
        $ibadahSchedule = Ibadah::all();
        return view('daftar-pengajaran.addPengajaran', compact('ibadahSchedule'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $data = request()->validate([
            'ibadah_id' => 'required',
            'topik' => 'required',
            'pembawa' => 'required',
        ]);
        // dd($data);  
        $pengajaran = new Pengajaran([
            'ibadah_id' => $data['ibadah_id'],
            'topik' => $data['topik'],
            'pembawa' => $data['pembawa'],
        ]);
        // dd($pengajaran);
        $pengajaran->save();

        return redirect('/jadwal-pengajaran')->with('success', 'Jadwal Pengajaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengajaran = Pengajaran::where('ibadah_id', $id)->first();
        $ibadahPengajaran = Ibadah::find($id);
        $ibadahs = Ibadah::all();
        return view('daftar-pengajaran.edit.pengajaran', compact('pengajaran', 'ibadahPengajaran', 'ibadahs'));
    }

    public function update($id) {
        $data = request()->validate([
            'ibadah_id' => 'required',
            'topik' => 'required',
            'pembawa' => 'required',
        ]);
        $pengajaran = Pengajaran::where('id', $id)->first();
        $pengajaran->update($data);
        return redirect('/jadwal-pengajaran')->with('success', 'Jadwal Pengajaran berhasil diubah');
    }
}
