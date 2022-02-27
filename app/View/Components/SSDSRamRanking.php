<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SSDSRamRanking extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site;
    public $samid;

    public function __construct($site, $samid)
    {
        $this->site = $site;
        $this->samid = $samid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.s-s-d-s-ram-ranking');
    }
}
