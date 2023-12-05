<?php

namespace App\Exports;

use App\Models\Finance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class FinanceExport implements FromView
{
    public function view(): View
    {
        $finances = Finance::all(); // Update the model class accordingly
        $totalPemasukkan = 0;
        $totalPengeluaran = 0;

        return view('exports.finances', compact('finances', 'totalPemasukkan', 'totalPengeluaran'));
    }
}

