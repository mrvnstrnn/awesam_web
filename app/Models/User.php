<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;
use App\Models\ProfilePermission;
use App\Models\UserDetail;
use App\Models\Profile;
use App\Models\VendorProgram;
use App\Models\SubActivityValue;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // protected $connection = 'mysql2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'name',
        'email',
        'password',
        'profile_id',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function can_do($checkPermission)
    {
        // dd($checkPermission);

        $collection = collect();
        $permissions = Permission::where('slug', $checkPermission)
                                    ->get();
        if(is_null($permissions)) {
            return false;
        } else {
            foreach ($permissions as $permission) {
                $profilePermission = ProfilePermission::where('profile_id', \Auth::user()->profile_id)
                        ->where('permission_id', $permission->id)
                        ->first();

                if(!is_null($profilePermission)){
                    $collection->push($profilePermission);
                }
            }
            
            return count($collection->all()) > 0 ? true : false;
        }
    }

    public function getAllNavigation()
    {

        $programs = \Auth::user()->getUserProgram();

        $user_programs = array();

        foreach($programs as $user_program){

            array_push($user_programs, $user_program->program_id);
        }

        // $user_programs = (object) $user_programs;



        // $perms = \DB::table('view_profile_menus')
        //             ->select('icon', 'slug', 'menu', 'permission_id', 'sort', 'title', 'title_subheading','level_one', 'level_two', 'level_three')
        //             ->distinct()
        //             ->where('profile_id', \Auth::user()->profile_id)
        //             ->whereIn('program_id', $user_programs);
        

        // return $perms;


        $perms = ProfilePermission::join('permissions', 'permissions.id', 'profile_permissions.permission_id')
                    ->select('menu_sort', 'icon', 'slug', 'menu', 'permission_id', 'sort', 'title', 'title_subheading','level_one', 'level_two', 'level_three')
                    ->distinct()
                    ->join('profiles', 'profiles.id', 'profile_permissions.profile_id')
                    ->where('profile_permissions.profile_id', \Auth::user()->profile_id)
                    ->whereIn('profile_permissions.program_id', $user_programs);

        // dd($perms);

        return $perms;

    }

    public function getUserProfile()
    {
        if (is_null(\Auth::user()->profile_id)) {
            return Profile::find(2);
        } else {
            return Profile::find(\Auth::user()->profile_id);
        }
    }

    public function getUserDetail()
    {
        return UserDetail::join('users', 'users.id', 'user_details.user_id')->where('user_details.user_id', \Auth::user()->id);
    }


    public function getCompany()
    {
        return Vendor::join('user_details', 'user_details.vendor_id', 'vendor.vendor_id')
                            ->where('user_details.user_id', \Auth::user()->id)
                            ->first();
    }

    public function vendor_list_based_program ($program_id)
    {
        return VendorProgram::select('vendor.vendor_id', 'vendor.vendor_sec_reg_name', 'vendor.vendor_acronym')
                            ->join('vendor', 'vendor.vendor_id', 'vendor_programs.vendors_id')
                            ->where('vendor_programs.programs', $program_id)
                            ->get();
    }

    public function allRoles()
    {
        return Profile::get();
    }

    public function getUserProgram($vendor_id = null)
    {
        if (is_null($vendor_id)) {
            return \DB::table('program')
                    ->join('user_programs', 'program.program_id', 'user_programs.program_id')
                    // ->join('page_route', 'page_route.program_id', 'user_programs.program_id')
                    ->where('user_programs.user_id', \Auth::user()->id)
                    // ->where('page_route.profile_id', \Auth::user()->profile_id)
                    ->orderBy('program.program_id', 'asc')
                    ->get();
        } else {
            return VendorProgram::select('program.program_id', 'program.program')
                                                            ->join('program', 'program.program_id', 'vendor_programs.programs')
                                                            ->where('vendor_programs.vendors_id', $vendor_id)
                                                            ->orderBy('program.program_id', 'asc')
                                                            ->get();
        }
    }

    public function getUserProgramEndorsement($route)
    {
        return \DB::table('program')
                        ->join('user_programs', 'program.program_id', 'user_programs.program_id')
                        ->join('page_route', 'page_route.program_id', 'user_programs.program_id')
                        ->where('user_programs.user_id', \Auth::user()->id)
                        ->where('page_route.profile_id', \Auth::user()->profile_id)
                        ->where('page_route.route_name', $route)
                        ->orderBy('program.program_id', 'asc')->get();
    }

    public function getUserProgramAct($activity, $program_id)
    {
        return \DB::table('page_route')
                            ->where('profile_id', \Auth::user()->profile_id)
                            ->where('program_id', $program_id)
                            ->where('activity_id', $activity)
                            ->first();
    }

    public function getMyRequest($request_status)
    {

        if(\Auth::user()->profile_id == 3){
            return \DB::table('request')
                            ->select(
                                'users.name',
                                'users.email',
                                'request.id',
                                'request.request_type',
                                'request.start_date_requested',
                                'request.end_date_requested',
                                'request.reason',
                                'request.leave_status',
                                'request.date_created',
                                'users.name',
                            )
                            ->join('users', 'users.id', 'request.agent_id')
                            ->where('request.supervisor_id', \Auth::user()->id)
                            ->where('request.leave_status', $request_status)
                            ->get();
        } else {
            return \DB::table('request')
                            ->join('users', 'users.id', 'request.agent_id')
                            ->where('request.agent_id', \Auth::user()->id)
                            ->where('request.leave_status', $request_status)
                            ->get();
        }
    }

    public function vendor_list($program_status)
    {
        
        if ($program_status == 'listVendor') {
            $arrayProgram = ['Active', 'Ongoing Accreditation'];
        } else if($program_status == 'OngoingOff') {
            $arrayProgram = ['Ongoing Offboarding'];
        } else if($program_status == 'Complete') {
            $arrayProgram = ['Complete Offboarding'];
        }

        return $vendors = \DB::table('vendor')
                                    ->whereIn('vendor_status', $arrayProgram)
                                    ->get();
    }

    public function checkIfSubActUploaded($sub_activity_id, $sam_id)
    {
        $sub_act = SubActivityValue::select('id')
                                        ->where('sub_activity_id', $sub_activity_id)
                                        ->where('sam_id', $sam_id)
                                        ->where('type', 'doc_upload')
                                        ->first();

        return $sub_act;
    }

    public function substep_complete($sub_activity_step_id, $sam_id, $sub_activity_id)
    {
        $substeps = SubActivityValue::select('id')
                        ->where('type', 'substep')
                        ->where('sam_id', $sam_id)
                        ->whereJsonContains("value", [
                            "sub_activity_step_id" => $sub_activity_step_id,
                            "sub_activity_id" => $sub_activity_id
                        ])
                        ->get();
        return $substeps;
    }

    public function substep_all($sam_id, $sub_activity_id)
    {
        $subactivity_all = SubActivityValue::select('id')
                        ->where('type', 'substep')
                        ->where('sam_id', $sam_id)
                        ->whereJsonContains("value", [
                            "sub_activity_id" => $sub_activity_id
                        ])
                        ->get();
        
        $substeps = $this->subactivity_step($sub_activity_id);

        if ($substeps->count() == $subactivity_all->count()) {
            $count = "same";
        } else {
            $count = "not_same";
        }

        return $count;
    }

    public function subactivity_step($sub_activity_id, $select = null)
    {
        if (is_null($select)) {
            $sub_steps = \DB::table('sub_activity_step')->where('sub_activity_id', $sub_activity_id)->get();
            return $sub_steps;
        } else {
            $sub_steps = \DB::table('sub_activity_step')->select('sub_activity_step_id')->where('sub_activity_id', $sub_activity_id)->get();
            return $sub_steps;
        }
    }

    public function getRtbApproved  ($sam_id)
    {
        $rtb_declaration = SubActivityValue::where('sam_id', $sam_id)
                        ->select('sub_activity_value.date_approved', 'users.name')
                        ->join('users', 'users.id', 'sub_activity_value.approver_id')
                        ->where('sub_activity_value.type', 'rtb_declaration')
                        ->first();

        return $rtb_declaration;
    }

    public function check_schedule_jtss ($sam_id)
    {
        $schedule_jtss = SubActivityValue::where('sam_id', $sam_id)
                        ->where('type', 'jtss_schedule')
                        ->get();

        return $schedule_jtss;
    }

    public function newsite_count_site($activity = "", $program_id)
    {
        if ( $activity == "completed" ) {
            $last_act = \DB::table("stage_activities")
                        ->select('activity_id')
                        ->where('program_id', $program_id)
                        ->orderBy('activity_id', 'desc')
                        ->first();

            $sites = \DB::table("site")
                        ->select('sam_id')
                        ->where('program_id', $program_id)
                        ->where('activities->activity_id', $last_act->activity_id)
                        ->get();
                        
        } else if ( $activity != "" ) {
            $sites = \DB::table("site")
                            ->select('sam_id')
                            ->where('program_id', $program_id)
                            ->where('activities->activity_id', $activity)
                            ->get();
        } else if ( $activity == "" ) {
            $last_act = \DB::table("stage_activities")
                                ->select('activity_id')
                                ->where('program_id', $program_id)
                                ->orderBy('activity_id', 'desc')
                                ->first();

            $sites = \DB::table("site")
                                ->select('sam_id')
                                ->where('program_id', $program_id)
                                ->get();
        }
        
        return count($sites);
    }

    public function counter_vendor_agent_supervisor($type)
    {
        if ($type = "assigned sites") {
            return \DB::select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[0]->counter;
        } else if ($type = "sites with issues") {
            return \DB::select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[1]->counter;
        } else if ($type = "ongoing doc validation") {
            return \DB::select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[2]->counter;
        } else if ($type = "completed sites") {
            return \DB::select('call `counter_vendor_agent_supervisor`('. \Auth::id() .')')[3]->counter;
        }
    }

    public function get_lrn ($sam_id, $type)
    {
        $lrn = SubActivityValue::where('sam_id', $sam_id)
                                    ->where('status', 'approved')
                                    ->where('type', $type)
                                    ->first();

        return $lrn->value;
    }

    public function get_refx ($sam_id, $type)
    {
        $lrn = SubActivityValue::where('sam_id', $sam_id)
                                    ->where('status', 'pending')
                                    ->where('type', $type)
                                    ->first();

        return $lrn->value;
    }

    public function get_program_renewal ($sam_id)
    {
        $get_program_renewal = \DB::table('program_renewal')
                    ->where('sam_id', $sam_id)
                    ->first();
                    
        return !is_null($get_program_renewal) ? $get_program_renewal : "";
    }

    public function get_program_renewal_old ($sam_id)
    {
        $get_program_renewal_old = \DB::table('program_renewal')
                    ->select('rate_old', 'escalation_old', 'tco_old')
                    ->where('sam_id', $sam_id)
                    ->first();
                    
        return !is_null($get_program_renewal_old) ? $get_program_renewal_old : "";
    }
    
}
