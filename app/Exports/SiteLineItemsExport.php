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
        $site_items = FsaLineItem::select('fsa_table.region', 'fsa_table.finance_code', 'fsa_table.category', 'fsa_table.item', 'fsa_table.price')
                                    ->join('fsa_table', 'fsa_table.fsa_id', 'site_line_items.fsa_id')
                                    ->where('site_line_items.sam_id', $this->sam_id)
                                    ->get();

        return $site_items->groupBy('fsa_table.category');
    }

    public function headings() :array
    {
        return [
            "Region", 
            "Finance Code", 
            "Category", 
            "Item", 
            "Price", 
        ];
    }

    public function title(): string
    {
        return $this->sam_id;
    }
}
