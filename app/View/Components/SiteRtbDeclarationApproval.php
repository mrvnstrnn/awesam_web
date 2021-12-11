<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\SubActivityValue;

class SiteRtbDeclarationApproval extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $site;

    public function __construct($site)
    {
        $this->site = $site;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $rtbdeclaration = SubActivityValue::where('sam_id', $this->site[0]->sam_id)
        ->where('status', "pending")
        ->where('type', "rtb_declaration")
        ->first();
        

        return view('components.site-rtb-declaration-approval', compact("rtbdeclaration"));
    }
}
