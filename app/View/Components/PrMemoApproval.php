<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PrMemoApproval extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site, $samid, $prmemo, $activity;

    public function __construct($site, $samid, $prmemo, $activity)
    {
        $this->site = $site;
        $this->samid = $samid;
        $this->prmemo = $prmemo;
        $this->activity = $activity;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pr-memo-approval');
    }
}
