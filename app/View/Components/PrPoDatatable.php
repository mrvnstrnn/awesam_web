<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrPoDatatable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $tableheader;
    public $ajaxdatatablesource;
    public $activitytype;

    public function __construct($tableheader, $ajaxdatatablesource, $activitytype)
    {
        $this->ajaxdatatablesource = $ajaxdatatablesource;
        $this->tableheader = $tableheader;
        $this->activitytype = $activitytype;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pr-po-datatable');
    }
}
