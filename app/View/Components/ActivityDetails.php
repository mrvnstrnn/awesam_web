<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;


class Activitydetails extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $activityid;
    public $activityname;
    public $sitename;
    public $samid;
    public $startdate;
    public $enddate;
    public $subactivities;
    public $activitycomplete;
    public $mode;



    public function __construct($activityid, $activityname, $sitename, $samid, $startdate, $enddate, $subactivities, $activitycomplete, $mode)
    {
        //
        $this->activityid = $activityid;
        $this->activityname = $activityname;
        $this->sitename = $sitename;
        $this->samid = $samid;
        $this->startdate = $startdate;
        $this->enddate = $enddate;
        $this->subactivities = $subactivities;
        $this->activitycomplete = $activitycomplete;
        $this->mode = $mode;

    }

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
            if(($this->startdate <= Carbon::now()->endOfWeek()->toDateString()) && ($this->enddate >= Carbon::now()->startOfWeek()->toDateString())){
                $sched = array('color'=>"warning", 'message'=>'on schedule');
                return $sched;
            }
            elseif($this->startdate <= Carbon::now()->toDateString() && $this->activitycomplete == false){
                $sched = array('color'=>"danger", 'message'=>'delayed');
                return $sched;
            }    
        }
        elseif($this->mode=="month"){

            $firstofthemonth = new Carbon('last day of this month');
            $endofthemonth = new Carbon('first day of this month');

            if(($this->startdate <= $firstofthemonth) && ($this->enddate >= $endofthemonth )){
                $sched = array('color'=>"warning", 'message'=>'on schedule');
                return $sched;
            }
            elseif(($this->enddate <= $firstofthemonth) && $this->activitycomplete == false){
                $sched = array('color'=>"danger", 'message'=>'delayed');
                return $sched;
            }    
        }
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activity-details');
    }
}
