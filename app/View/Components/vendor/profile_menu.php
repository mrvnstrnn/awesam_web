<?php

namespace App\View\Components\vendor;

use Illuminate\View\Component;

class profile_menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($profile, $menu)
    {
        //

        $this->profile = $profile;
        $this->menu = $menu;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vendor.profile_menu');
    }
}
