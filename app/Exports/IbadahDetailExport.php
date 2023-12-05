<?php

namespace App\Exports;

use App\Models\Ibadah;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IbadahDetailExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $ibadahId;

    public function __construct($ibadahId)
    {
        $this->ibadahId = $ibadahId;
    }

    public function view(): View
    {
        $ibadah = Ibadah::where('id', $this->ibadahId)->first();

        return view('exports.ibadah_detail', compact('ibadah'));
    }
}
