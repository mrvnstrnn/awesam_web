<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteRtbDeclaration extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $activityid, $sitecategory, $samid;

    public function __construct($activityid, $sitecategory, $samid)
    {
        $this->activityid = $activityid;
        $this->sitecategory = $sitecategory;
        $this->samid = $samid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-rtb-declaration');
    }
}
