<?php

namespace App\Http\Controllers;

use App\Exports\FinanceExport;
use App\Models\Finance;
use App\Models\Pemasukkan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('created_at', 'desc')->get();

        // dd($finances);
        return view('finance.index', compact('finances'));
    }

    public function create()
    {
        return view('finance.addFinance');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $finance = new Finance([
            'nama' => $request->get('nama'),
            'jenis' => ($data['jenis'] == "Pemasukkan") ? 1 : 2
        ]);
        $finance->save();

        if($data['jenis'] == "Pemasukkan") {
            $pemasukkan = new Pemasukkan([
                'nama' => $data['nama'],
                'nominal' => $data['nominal'],
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'finance_id' => $finance->id,
            ]);
            $pemasukkan->save();
        } else {
            $pengeluaran = new Pengeluaran([
                'nama' => $data['nama'],
                'nominal' => $data['nominal'],
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'finance_id' => $finance->id, 
            ]);
            $pengeluaran->save();
        }
        return redirect('/finance')->with('success', 'Data Finance berhasil ditambahkan');
    }

    public function export () {
        return Excel::download(new FinanceExport, 'finances.xlsx');
    }

    public function edit($id)
    {
        $finance = Finance::find($id);
        // dd($finance->jenis);
        // dd($finance->pemasukkan, $finance->pengeluaran);
        
        return view('finance.edit', compact('finance'));
    }

    public function update(Request $request, $id)
    {
        $finance = Finance::find($id);

        $data = $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'nominal' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $finance->nama = $data['nama'];
        $finance->jenis = ($data['jenis'] == "Pemasukkan") ? 1 : 2;
        $finance->save();

        if ($data['jenis'] == "Pemasukkan") {
            $pemasukkan = Pemasukkan::where('finance_id', $finance->id)->first();

            if (!$pemasukkan) {
                $pemasukkan = new Pemasukkan();
                $pemasukkan->finance_id = $finance->id;
            }

            $pemasukkan->nominal = $data['nominal'];
            $pemasukkan->tanggal = $data['tanggal'];
            $pemasukkan->keterangan = $data['keterangan'];
            $pemasukkan->save();
        } else {
            $pengeluaran = Pengeluaran::where('finance_id', $finance->id)->first();

            if (!$pengeluaran) {
                $pengeluaran = new Pengeluaran();
                $pengeluaran->finance_id = $finance->id;
            }

            $pengeluaran->nominal = $data['nominal'];
            $pengeluaran->tanggal = $data['tanggal'];
            $pengeluaran->keterangan = $data['keterangan'];
            $pengeluaran->save();
        }

        return redirect('/finance')->with('success', 'Data Finance berhasil diubah');
    }


    public function destroy($id)
    {
        $finance = Finance::find($id);

        if (!$finance) {
            return redirect('/finance')->with('error', 'Data Finance tidak ditemukan');
        }

        if ($finance->jenis == 1) {
            $pemasukkan = Pemasukkan::where('finance_id', $finance->id)->first();

            if ($pemasukkan) {
                $pemasukkan->delete();
            }
        } else {
            $pengeluaran = Pengeluaran::where('finance_id', $finance->id)->first();

            if ($pengeluaran) {
                $pengeluaran->delete();
            }
        }

        $finance->delete();

        return redirect('/finance')->with('success', 'Data Finance berhasil dihapus');
    }

}
