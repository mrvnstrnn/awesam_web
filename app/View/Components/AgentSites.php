<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AgentSites extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $agentsites;

    public function __construct($agentsites)
    {
        //
        $this->agentsites = $agentsites;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.agent-sites');
    }
}
