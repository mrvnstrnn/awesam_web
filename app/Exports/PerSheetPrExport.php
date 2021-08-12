<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\PrMemoSite;

class PerSheetPrExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $generated_pr;
    
    function __construct($generated_pr) {
        $this->generated_pr = $generated_pr;
    }

    public function sheets(): array
    {
        $get_all_sites = PrMemoSite::where('pr_memo_id', $this->generated_pr)->get();
        $sam_ids = [];

        foreach ($get_all_sites as $get_all_site) {
            $sam_ids[] = new SiteLineItemsExport($get_all_site->sam_id);
        }

        return $sam_ids;
    }
}
