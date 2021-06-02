<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActivityListItem extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    public $what_activity;

    public function __construct($what_activity)
    {
        //

        $this->what_activity = $what_activity;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activity-list-item');
    }
}
