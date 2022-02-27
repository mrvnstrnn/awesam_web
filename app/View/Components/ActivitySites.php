<?php

namespace App\View\Components;
use Carbon\Carbon;

use Illuminate\View\Component;

class ActivitySites extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * 
     */


    public $sitename;
    public $samid;
    public $activityname;
    public $startdate;
    public $enddate;
    public $activitycomplete;
    public $mode;
    public $profile;
    public $agentid;



    public function __construct($sitename, $samid, $activityname, $startdate, $enddate, $activitycomplete, $mode, $profile, $agentid)
    {
        $this->sitename = $sitename;
        $this->samid = $samid;
        $this->activityname = $activityname;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->$activitycomplete = $activitycomplete;
        $this->mode = $mode;
        $this->profile = $profile;
        $this->agentid = $agentid;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */

    public function scheduleStatus()
    {
        if($this->mode=="today"){
            if(($this->startdate <= Carbon::now()->toDateString()) && ($this->enddate >= Carbon::now()->toDateString())){
                $sched = array('color'=>"warning", 'message'=>'on schedule');
                return $sched;
            }
            elseif($this->startdate <= Carbon::now()->toDateString() && $this->activitycomplete == false){
                $sched = array('color'=>"danger", 'message'=>'delayed');
                return $sched;
            }    
        }
        elseif($this->mode=="week"){
            if(($this->startdate <= Carbon::now()->toDateString()) && ($this->enddate >= Carbon::now()->toDateString())){
                $sched = array('color'=>"warning", 'message'=>'on schedule');
                return $sched;
            }
            elseif($this->startdate <= Carbon::now()->toDateString() && $this->activitycomplete == false){
                $sched = array('color'=>"danger", 'message'=>'delayed');
                return $sched;
            }    
        }
        elseif($this->mode=="month"){
            if(($this->startdate <= Carbon::now()->toDateString()) && ($this->enddate >= Carbon::now()->toDateString())){
                $sched = array('color'=>"warning", 'message'=>'on schedule');
                return $sched;
            }
            elseif($this->startdate <= Carbon::now()->toDateString() && $this->activitycomplete == false){
                $sched = array('color'=>"danger", 'message'=>'delayed');
                return $sched;
            }    
        }
    }



    public function render()
    {
        return view('components.activity-sites');
    }
}
