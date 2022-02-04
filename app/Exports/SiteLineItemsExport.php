<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\FsaLineItem;
use App\Models\PrMemoSite;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiteLineItemsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($sam_id) {
        $this->sam_id = $sam_id;
    }

    public function collection()
    {
        $site_items = FsaLineItem::select('fsaq.region_id', 'fsaq.category', 'fsaq.description', 'fsaq.amount')
                                    ->join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')
                                    ->where('site_line_items.sam_id', $this->sam_id)
                                    ->get();

        return $site_items->groupBy('fsa_table.category');
    }

    public function headings() :array
    {
        return [
            "Region", 
            "Category", 
            "Description", 
            "Amount", 
        ];
    }

    public function title(): string
    {
        return $this->sam_id;
    }
}
