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
    public $samid;

    public function __construct($completed, $samid)
    {
        $this->completed = $completed;
        $this->samid = $samid;
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
