<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteActivities extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $site;

    public function __construct($site)
    {
        $this->site = $site;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-activities');
    }
}
