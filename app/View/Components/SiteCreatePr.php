<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteCreatePr extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $site;
    public $activity;

    public function __construct($site, $activity)
    {
        $this->site = $site;
        $this->activity = $activity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-create-pr');
    }
}
