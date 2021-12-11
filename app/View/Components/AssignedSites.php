<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AssignedSites extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $mode;

    public function __construct($mode)
    {
        //
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.assigned-sites');
    }
}
