<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActivitiesTab extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $activities;
    public $mode;
    public $profile;

    public function __construct($activities, $mode, $profile)
    {
        //
        $this->activities = $activities;
        $this->mode = $mode;
        $this->profile = $profile;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities-tab');
    }
}
