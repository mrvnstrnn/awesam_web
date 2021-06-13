<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ViewSiteActivities extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    public $activities;
    public $samid;

    public function __construct($activities, $samid)
    {
        //
        $this->activities  = $activities;
        $this->samid = $samid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.view-site-activities');
    }
}
