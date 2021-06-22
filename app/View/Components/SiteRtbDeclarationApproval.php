<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteRtbDeclarationApproval extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $rtbdeclaration;

    public function __construct($rtbdeclaration)
    {
        $this->rtbdeclaration = $rtbdeclaration;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-rtb-declaration-approval');
    }
}
