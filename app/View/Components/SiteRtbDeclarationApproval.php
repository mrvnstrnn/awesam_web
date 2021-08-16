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
    public $rtbdeclaration, $activityid, $sitecategory;

    public function __construct($rtbdeclaration, $activityid, $sitecategory)
    {
        $this->rtbdeclaration = $rtbdeclaration;
        $this->activityid = $activityid;
        $this->sitecategory = $sitecategory;
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
