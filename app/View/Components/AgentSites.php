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
    public $agentname;

    public function __construct($agentsites, $agentname)
    {
        //
        $this->agentsites = $agentsites;
        $this->agentname = $agentname;

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
