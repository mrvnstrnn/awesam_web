<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteScheduleJtss extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $samid, $activityid, $sitecategory;
    public function __construct($samid, $activityid, $sitecategory)
    {
        $this->samid = $samid;
        $this->activityid = $activityid;
        $this->sitecategory = $sitecategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-schedule-jtss');
    }
}
