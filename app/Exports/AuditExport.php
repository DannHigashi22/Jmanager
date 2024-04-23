<?php

namespace App\Exports;

use App\Models\Audit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuditExport implements FromView, ShouldAutoSize ,ShouldQueue
{
    private $audits;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($audits) {
        $this->audits = $audits;
    }
    public function view(): View
    {
     return view('audit.export',['audits'=>$this->audits]);
    }
}
