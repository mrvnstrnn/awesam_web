<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DatatableMiniDashboardNewsites extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $tableheader;

    public $minidashboard;

    public function __construct($tableheader)
    {

        $this->tableheader = $tableheader;

        $this->minidashboard = \DB::table('view_MiniDashboard_newsites');

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.datatable-mini-dashboard-newsites', compact($this->minidashboard));
    }
}
