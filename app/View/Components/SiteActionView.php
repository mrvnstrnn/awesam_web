<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteActionView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site, $main_activity, $rtbdeclaration, $pr;

    public function __construct($site, $main_activity = null, $rtbdeclaration = null, $pr = null)
    {
        $this->site = $site;
        $this->main_activity = $main_activity;
        $this->rtbdeclaration = $rtbdeclaration;
        $this->pr = $pr;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-action-view');
    }
}
