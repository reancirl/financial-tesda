<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PurchaseRequestExport implements FromView, ShouldAutoSize
{
   
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $data = $this->data;

        return view('reports.purchase_request', [
            'data' => $data
        ]);
    }
}
