<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SitePRApproval extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site, $pr, $activity;

    public function __construct($site, $pr, $activity)
    {
        $this->site = $site;
        $this->pr = $pr;
        $this->activity = $activity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-p-r-approval');
    }
}
