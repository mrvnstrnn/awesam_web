<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\FsaLineItem;
use App\Models\SubActivityValue;
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
        $sub_act_val = SubActivityValue::select('user_id')
                                    ->where('sam_id', $this->sam_id)
                                    ->first();

        $site_items = FsaLineItem::select('location_regions.region_name', 'fsaq.category', 'fsaq.description', 'fsaq.amount')
                                    ->join('fsaq', 'fsaq.fsaq_id', 'site_line_items.fsa_id')

                                    ->join('location_regions', 'location_regions.region_id', 'fsaq.region_id')

                                    ->where('site_line_items.sam_id', $this->sam_id)
                                    ->where('site_line_items.user_id', $sub_act_val->user_id)

                                    ->where('fsaq.site_type', "EASY")
                                    ->where('fsaq.account_type', "BAU")
        
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
