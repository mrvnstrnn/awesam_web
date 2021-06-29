<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SiteActionView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
// <<<<<<< HEAD
//     public $site, $main_activity, $rtbdeclaration, $pr;

//     public function __construct($site, $main_activity = null, $rtbdeclaration = null, $pr = null)
//     {
//         $this->site = $site;
//         $this->main_activity = $main_activity;
//         $this->rtbdeclaration = $rtbdeclaration;
//         $this->pr = $pr;
// =======
    public $site, $mainactivity;

    public function __construct($site, $mainactivity)
    {
        $this->site = $site;
        $this->mainactivity = $mainactivity;
// >>>>>>> d7678de5140ba4a9d871594616f919bd12b15546
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site-action-view');
    }
}
