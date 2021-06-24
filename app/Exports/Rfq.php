<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Rfq implements FromView, ShouldAutoSize
{
    protected $pr;

    function __construct($pr) 
    {
        $this->pr = $pr;
    }

    public function view(): View
    {	
        $pr = $this->pr;

        return view('reports.rfq', compact('pr'));
    }
}
