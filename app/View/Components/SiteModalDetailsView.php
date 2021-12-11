<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteModalDetailsView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $site;
    public $mainactivity;

    public function __construct($site, $mainactivity)
    {
        $this->site = $site;
        $this->mainactivity = $mainactivity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-modal-details-view');
    }
}
