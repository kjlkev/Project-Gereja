<?php

namespace App\Http\Controllers;

use App\Exports\IbadahDetailExport;
use App\Exports\IbadahExport;
use App\Models\AlatAVL;
use App\Models\AudioVisual;
use App\Models\Avl;
use App\Models\Ibadah;
use App\Models\Instrument;
use App\Models\Pemusik;
use App\Models\Pengajaran;
use App\Models\User;
use App\Models\Usher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class JadwalIbadahController extends Controller
{
    public function index()
    {
        $ibadahSchedule = Ibadah::with('ushers', 'pemusiks', 'avls')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('jadwal-ibadah.index', compact('ibadahSchedule'));
    }
    
    public function create() {
        $users = User::whereNotIn('id', [1])->get();
        $instruments = Instrument::all();
        $avls = AlatAVL::all();
        return view('jadwal-ibadah.addIbadah', compact('users', 'instruments', 'avls'));
    }
    
    public function update(Request $request, $ibadahId){
        $validatedData = $request->validate([
            'tanggal' => 'required',
            'nama' => 'required',
            'topik' => 'required',
            'pembawa' => 'required',
        ]);

        $ibadah = Ibadah::find($ibadahId);
        $ibadah->update($validatedData);
        return redirect()->back()->with('success', 'Jadwal Ibadah berhasil diubah!');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'nama' => 'required',
            'topik' => 'required',
            'pembawa' => 'required',
        ]);
        // Create a new Ibadah instance with basic data
        $ibadah = new Ibadah([
            'tanggal' => $request->get('tanggal'),
            'nama' => $request->get('nama'),
            'topik' => $request->get('topik'),
            'pembawa' => $request->get('pembawa'),
        ]);
        $ibadah->save();

        $pemusiks = $request->get('selectedPemusik');
        if($pemusiks) {
            foreach($pemusiks as $item) {
                if(isset($item['pemusikId']) && isset($item['instrumentId'])
                    && $item['pemusikId'] && $item['instrumentId']
                ) {
                    $pemusikData = [
                        'user_id' => isset($item['pemusikId']) ? $item['pemusikId'] : null,
                        'instrument_id' => isset($item['instrumentId']) ? $item['instrumentId'] : null,
                        'ibadah_id' => $ibadah->id,
                    ];
                    $pemusik = new Pemusik($pemusikData);
                    $pemusik->save();
                }
            }
        }

        $avls = $request->get('selectedAVL');
        if($avls) {
            foreach($avls as $item) {
                if(isset($item['avlId']) && isset($item['alatId'])
                    && $item['avlId'] && $item['alatId']) {
                    $avl = new Avl([
                        'user_id' => isset($item['avlId']) ? $item['avlId'] : null,
                        'alatAvl_id' => isset($item['alatId']) ? $item['alatId'] : null,
                        'ibadah_id' => $ibadah->id,
                    ]);
                    $avl->save();
                }
            }
        }

        $ushers = $request->get('selectedUsher');
        if($ushers) {
            foreach($ushers as $item) {
                $usher = new Usher([
                    'user_id' => $item,
                    'ibadah_id' => $ibadah->id,
                ]);
                $usher->save();
            }
        }

        
        return redirect('/jadwal-ibadah')->with('success', 'Jadwal Ibadah berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $ibadah = Ibadah::find($id);
        $ushers = Usher::where('ibadah_id', $id)->get();
        $pemusiks = Pemusik::where('ibadah_id', $id)->get();
        $avls = Avl::where('ibadah_id', $id)->get();
        $instruments = Instrument::all();
        $pengajarans = Pengajaran::where('ibadah_id', $id)->get();
        return view('jadwal-ibadah.edit', compact('ibadah', 'ushers', 'instruments', 'avls', 'pemusiks', 'pengajarans'));
    }

    public function editUshers($id)
    {
        $ibadah = Ibadah::find($id);
        $users = User::whereNotIn('id', [1])->whereNotIn('id', $ibadah->ushers->pluck('user_id'))->get();
        $ushers = Usher::where('ibadah_id', $id)->get();
        return view('jadwal-ibadah.edit.usher', compact('ibadah', 'ushers', 'users'));
    }

    public function editPemusiks($id) {
        $ibadah = Ibadah::find($id);
        $users = User::whereNotIn('id', [1])->whereNotIn('id', $ibadah->pemusiks->pluck('user_id'))->get();
        $instruments = Instrument::all();
        $pemusiks = Pemusik::where('ibadah_id', $id)->get();
        return view('jadwal-ibadah.edit.pemusik', compact('ibadah', 'pemusiks', 'users', 'instruments'));
    }

    public function editAudioVisuals($id) {
        $ibadah = Ibadah::find($id);
        $users = User::whereNotIn('id', [1])->whereNotIn('id', $ibadah->avls->pluck('user_id'))->get();
        $avls = Avl::where('ibadah_id', $id)->get();
        $alatAvls = AlatAVL::all();
        return view('jadwal-ibadah.edit.avl', compact('ibadah', 'avls', 'users', 'alatAvls'));
    }

    public function editPengajarans($id) {
        $ibadah = Ibadah::find($id);
        $pengajarans = Pengajaran::where('ibadah_id', $id)->get();
        $ibadahPengajaran = Ibadah::find($id);
        return view('jadwal-ibadah.edit.pengajaran', compact('ibadah', 'pengajarans', 'ibadahPengajaran'));
    }


    public function addIbadahUshers(Request $request, $ibadahId) 
    {
        // dd($ibadahId);
        // dd($request->all());
        $ushers = $request->get('selectedUsher');
        if($ushers == null) {
            return redirect()->back()->with('error', 'Usher tidak boleh kosong!');
        }
        if($ushers) {
            foreach($ushers as $item) {
                $usher = new Usher([
                    'user_id' => $item,
                    'ibadah_id' => $ibadahId,
                ]);
                $usher->save();
            }
        }
        return redirect()->back()->with('success', 'Usher berhasil ditambahkan!');
    }

    public function addIbadahPemusiks(Request $request, $ibadahId) {
        $pemusiks = $request->get('selectedPemusik');
        if($pemusiks[0]['pemusikId'] == null && $pemusiks[1]['instrumentId'] == null) {
            return redirect()->back()->with('error', 'Pemusik atau Instrument tidak boleh kosong!');
        }

        if($pemusiks) {
            foreach($pemusiks as $item) {
                $pemusikData = [
                    'user_id' => isset($item['pemusikId']) ? $item['pemusikId'] : null,
                    'instrument_id' => isset($item['instrumentId']) ? $item['instrumentId'] : null,
                    'ibadah_id' => $ibadahId,
                ];
                $pemusik = new Pemusik($pemusikData);
                $pemusik->save();
            }
        }
        return redirect()->back()->with('success', 'Pemusik berhasil ditambahkan!');
    }

    public function addIbadahAudioVisuals(Request $request, $ibadahId) {
        $avls = $request->get('selectedAVL');
        if($avls[0]['avlId'] == null && $avls[1]['alatId'] == null) {
            return redirect()->back()->with('error', 'Audio Visual atau Alat tidak boleh kosong!');
        }
        if($avls) {
            foreach($avls as $item) {
                $avl = new Avl([
                    'user_id' => isset($item['avlId']) ? $item['avlId'] : null,
                    'alatAvl_id' => isset($item['alatId']) ? $item['alatId'] : null,
                    'ibadah_id' => $ibadahId,
                ]);
                $avl->save();
            }
        }
        return redirect()->back()->with('success', 'Audio Visual berhasil ditambahkan!');
    }

    public function addIbadahPengajarans(Request $request, $ibadahId) {
        if($request->get('topik') == null && $request->get('pembawa') == null) {
            return redirect()->back()->with('error', 'Topik atau Pembawa tidak boleh kosong!');
        }
        $pengajaran = new Pengajaran([
            'ibadah_id' => $ibadahId,
            'topik' => $request->get('topik'),
            'pembawa' => $request->get('pembawa'),
        ]);
        $pengajaran->save();
        return redirect()->back()->with('success', 'Pengajaran berhasil ditambahkan!');
    }

    public function export() {
        return Excel::download(new IbadahExport, 'ibadah.xlsx');
    }

    public function exportDetail($id) {
        return Excel::download(new IbadahDetailExport($id), 'ibadah-detail.xlsx');
    }

    public function signup($ibadahId) {
        $user = Auth::user();
        $ibadah = Ibadah::find($ibadahId);
    
        if (!$ibadah) {
            return redirect()->back()->with('error', 'Ibadah not found.');
        }
    
        if (!$ibadah->users->contains($user)) {
            // Attach the user to the ibadah and set the timestamps
            $ibadah->users()->attach($user, ['created_at' => now(), 'updated_at' => now()]);
    
            return redirect()->back()->with('success', 'Anda telah berhasil mendaftar ke Ibadah ini.');
        } else {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di Ibadah ini.');
        }
    }

    public function getJemaat($id) {
        $ibadah = Ibadah::where('id', $id)
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($id);
        return view('jadwal-ibadah.jemaat', compact('ibadah'));
    }
}
