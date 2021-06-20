<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteStatus extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $completed;

    public function __construct($completed)
    {
        $this->completed = $completed;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-status');
    }
}
