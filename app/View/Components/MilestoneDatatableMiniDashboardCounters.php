<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MilestoneDatatableMiniDashboardCounters extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $programid;

    public function __construct($programid)
    {
        $this->programid = $programid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.milestone-datatable-mini-dashboard-counters');
    }
}
