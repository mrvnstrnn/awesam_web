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
    public $site, $mainactivity, $rtbdeclaration, $pr;

    public function __construct($site, $mainactivity, $rtbdeclaration, $pr)
    {
        $this->site = $site;
        $this->mainactivity = $mainactivity;
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
