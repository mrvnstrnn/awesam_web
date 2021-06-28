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
    public $site, $main_activity, $site_fields;

    public function __construct($site, $main_activity = null, $site_fields = null)
    {
        $this->site = $site;
        $this->main_activity = $main_activity;
        $this->site_fields = $site_fields;
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
