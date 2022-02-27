<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteDetails extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site;
    public $sitefields;

    public function __construct($site, $sitefields)
    {
        $this->site = $site;
        $this->sitefields = $sitefields;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-details');
    }
}
