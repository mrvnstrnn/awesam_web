<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\FsaLineItem;

class SiteLineItemsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $sam_id;

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
}
