<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalInfoSite extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site, $main_activity, $activity_component;

    public function __construct($site, $mainactivity, $activity_component)
    {
        $this->site = $site;
        $this->main_activity = $mainactivity;
        $this->activity_component = $activity_component;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-info-site');
    }
}
