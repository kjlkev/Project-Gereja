<?php

namespace App\Exports;

use App\Models\Ibadah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IbadahExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.ibadahs', [
            'ibadahs' => Ibadah::orderBy('created_at', 'desc')->get()
        ]);
    }
}
