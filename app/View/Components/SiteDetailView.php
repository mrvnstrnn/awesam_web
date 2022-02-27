<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteDetailView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site, $mainactivity, $sitefields;

    public function __construct($site, $mainactivity, $sitefields)
    {
        $this->site = $site;
        $this->mainactivity = $mainactivity;
        $this->sitefields = $sitefields;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-detail-view');
    }
}
