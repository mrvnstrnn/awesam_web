<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TowerCoModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $actor;

    public function __construct($actor)
    {
        $this->actor = $actor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tower-co-modal');
    }
}
