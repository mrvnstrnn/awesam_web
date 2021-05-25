<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Slug;
use App\Models\UserProfileMainMenu;
use App\Models\Invitation;
use App\Models\Company;
use App\Models\User;
use App\Models\Location;
use App\Models\UserDetail;
use DataTables;

use Illuminate\Support\Facades\Hash;
use Validator;

// use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
 
 
    // Main View For User
    // Should be profile dependent

    public function profile_switcher($profile_id)
    {
        try {
            User::where('id', \Auth::user()->id)
                    ->update([
                        'profile_id' => $profile_id
                    ]);
            
            return redirect('/');
        } catch (\Throwable $th) {
            return abort(404, $th);
        }
    }

    public function onboarding()
    {
        if(is_null(\Auth::user()->profile_id)){
            $locate = Location::select('region');
            $locations = $locate->groupBy('region')->get();

            $user_details = \Auth::user()->getUserDetail()->where('user_details.address_id', '!=', null)->first();
            return view('profiles.enrollment', compact('locations', 'user_details'));
        } else {
            return redirect('/');
        }
    }

    public function change_password(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'password' => ['required', 'min:8', 'confirmed:confirm-password'],
            ));

            if ($validate->passes()) {
                User::where('id', \Auth::user()->id)
                        ->update([
                            'password' => Hash::make($request->input('password')),
                            'first_time_login' => 1
                        ]);
                
                return response()->json(['error' => false, 'message' => "Successfully updated password." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function getAddress(Request $request)
    {
        try {
            $id = $request->input('id');
            $val = $request->input('val');

            if ($id == 'region') {
                $select = "province";
            } else if ($id == 'province') {
                $select = "lgu";
            } else {
                $select = 'lgu';
            }

            $locate = Location::select($select)->where($id, $val);

            $location = $locate->groupBy($select)->get();

            
            return response()->json(['error' => false, 'message' => $location, 'new_id' => $select ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function finish_onboarding(Request $request)
    {
        try {
            if (is_null($request->input('hidden_province')) || is_null($request->input('hidden_lgu')) || is_null($request->input('hidden_region'))) {
                return response()->json(['error' => true, 'message' => 'Address field id required.' ]);
            }

            $validate = \Validator::make($request->all(), array(
                'firstname' => 'required',
                // 'middlename' => 'required',
                'lastname' => 'required',
                // 'suffix' => 'required',
                // 'nickname' => 'required',
                'birthday' => 'required',
                'gender' => 'required',

                'email' => 'required',
                'contact_no' => 'required',
                // 'landline' => 'required',

                'designation' => 'required',
                'employment_classification' => 'required',
                'employment_status' => 'required',
                'hiring_date' => 'required',
            ));

            if($validate->passes()){

                $address = Location::where('province', $request->input('hidden_province'))
                                        ->where('lgu', $request->input('hidden_lgu'))
                                        ->where('region', $request->input('hidden_region'))
                                        ->first();
                                        
                $user_details = UserDetail::where('user_id', \Auth::user()->id)->first();
    
                User::where('id', \Auth::user()->id)
                        ->update([
                            'middlename' => $request->input('middlename'),
                            'nickname' => $request->input('nickname'),
                            'suffix' => $request->input('suffix'),
                            // 'profile_id' => $request->input('designation'),
                        ]);

                if(!is_null($user_details)){
                    UserDetail::where('user_id', \Auth::user()->id)
                                ->update([
                                    'birthday' => $request->get('birthday'),
                                    'gender' => $request->get('gender'),
                                    'contact_no' => $request->get('contact_no'),
                                    'landline' => $request->get('landline'),
                                    'designation' => $request->get('designation'),
                                    'employment_classification' => $request->get('employment_classification'),
                                    'employment_status' => $request->get('employment_status'),
                                    'hiring_date' => $request->get('hiring_date'),
                                    'address_id' => $address->id,
                                ]);

                    return response()->json(['error' => false, 'message' => 'Success updated details.' ]);
                } else {
                    // return response()->json(['error' => false, 'message' => $request->all() ]);
                    // UserDetail::create([
                    //     'address_id' => $address->id,
                    //     'user_id' => \Auth::user()->id,
                        
                    //     'birthday' => $request->get('birthday'),
                    //     'gender' => $request->get('gender'),
                    //     'contact_no' => $request->get('contact_no'),
                    //     'landline' => $request->get('landline'),
                    //     'designation' => $request->get('designation'),
                    //     'employment_classification' => $request->get('employment_classification'),
                    //     'employment_status' => $request->get('employment_status'),
                    //     'hiring_date' => $request->get('hiring_date'),
                    // ]);

                    $detail = new UserDetail();
                    $detail->address_id = $address->id;
                    $detail->user_id = \Auth::user()->id;
                    $detail->birthday = $request->get('birthday');
                    $detail->gender = $request->get('gender');
                    $detail->contact_no = $request->get('contact_no');
                    $detail->landline = $request->get('landline');
                    $detail->designation = $request->get('designation');
                    $detail->employment_classification = $request->get('employment_classification');
                    $detail->employment_status = $request->get('employment_status');
                    $detail->hiring_date = $request->get('hiring_date');

                    $detail->save();

                    return response()->json(['error' => false, 'message' => 'Success added details.' ]);
                }

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function site_vendor($vendor_id)
    {
        try {
            if(is_null(\Auth::user()->profile_id)){
                return redirect('/onboarding');
            } else {
                
                $role = \Auth::user()->getUserProfile();
    
                $mode = $role->mode;
                $profile = $role->profile;
    
                
                $title = ucwords(Auth::user()->name);
                $title_subheading  = ucwords($mode . " : " . $profile);
                $title_icon = 'home';
        
                $active_slug = "";
        
                $profile_menu = self::getProfileMenuLinks();
    
                $profile_direct_links = self::getProfileMenuDirectLinks();
                    
                $program_direct_links = self::getProgramMenuDirectLinks();

                
                $user = User::find($vendor_id);
                
                return view('profiles.globe.sts-vendor-admin.vendor-sites', 
                    compact(
                        'mode',
                        'profile',
                        'active_slug',
                        'profile_menu',
                        'profile_direct_links',
                        'program_direct_links',
                        'title', 
                        'title_subheading', 
                        'title_icon',
                        'vendor_id',
                        'user'
                    )
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index()
    {
        if(is_null(\Auth::user()->profile_id)){
            return redirect('/onboarding');
        } else {
            
            $role = \Auth::user()->getUserProfile();

            $mode = $role->mode;
            $profile = $role->profile;

            
            $title = ucwords(Auth::user()->name);
            $title_subheading  = ucwords($mode . " : " . $profile);
            $title_icon = 'home';
    
            $active_slug = "";
    
            $profile_menu = self::getProfileMenuLinks();

            $profile_direct_links = self::getProfileMenuDirectLinks();
                
            $program_direct_links = self::getProgramMenuDirectLinks();
    

            $profile_for_view = strtolower(str_replace(' ', '-', ucfirst($profile)));
            $view = 'profiles' . '.' .$mode. '.' .$profile_for_view. '.index';

            
            return view($view, 
                compact(
                    'mode',
                    'profile',
                    'active_slug',
                    'profile_menu',
                    'profile_direct_links',
                    'program_direct_links',
                    'title', 
                    'title_subheading', 
                    'title_icon'
                )
            );
        }
    }


    public function show($show = null, Request $request){

        if(is_null(\Auth::user()->profile_id)){
            return redirect('/onboarding');
        } else {
            $path = explode('/', $show);
            // LIMIT TWO LEVELS OF SLUGS FOR PAGES
            // USE THIRD SLUG LEVEL AS PARAMETER
            if(count($path) >= 3){
                $show = $path[0]."/".$path[1];
            }

            $role = \Auth::user()->getAllNavigation()
                                    ->where('permissions.slug', $show)
                                    ->get();

            $mode = $role[0]->mode;
            $profile = $role[0]->profile;

            $profile_for_view = strtolower(str_replace(' ', '-', ucfirst($profile)));

            if(count($role)>0){
                if(count($path) >= 3){
                    $view = $slug_info[0]['view'] . "_param";
                    $title = $path[2];
                } else if (count($path) == 2) {
                    $title = $role[0]->title;
                    $view = 'profiles' . '.' .$mode. '.' .$profile_for_view. '.index';
                } else {
                    $title = $role[0]->title;
                    $view = 'profiles' . '.' .$mode. '.' .$profile_for_view. '.' .end($path);
                }

                $title_subheading  = $role[0]->title_subheading;
                $title_icon = $role[0]->icon;
            
            } else {
                $title = "Not Found : "  . $path[0] . "/" . $path[1] . " : " . $show;
                $title_subheading  = "Link not available in your profile or still under construction";
                $title_icon = 'home';
                $view = 'profiles.' . $mode. '.' .$profile_for_view. '.index';
            }


            $active_slug = $show;

            $profile_menu = self::getProfileMenuLinks();

            $profile_direct_links = self::getProfileMenuDirectLinks();

            $program_direct_links = self::getProgramMenuDirectLinks();
            
            return view($view, 
                compact(
                    'mode',
                    'profile',
                    'active_slug',
                    'profile_menu',
                    'profile_direct_links',
                    'program_direct_links',
                    'title', 
                    'title_subheading', 
                    'title_icon'
                )
            );
        }

    }


    private function getProfileMenuLinks(){
        $profile_menu = \Auth::user()->getAllNavigation()
            ->orderBy('sort', 'asc')
            ->orderBy('menu', 'asc')
            ->get();

        return $profile_menu;

    }

    private function getProfileMenuDirectLinks(){
        $profile_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('permissions.level_one', 'profile_menu')
                                            ->orderBy('sort', 'asc')
                                            ->get();

        return $profile_direct_links->groupBy('level_two');

    }

    private function getProgramMenuDirectLinks(){
        $program_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('permissions.level_one', 'program_menu')
                                            ->orderBy('sort', 'asc')
                                            ->get();
        
        return $program_direct_links->groupBy('level_two');
    }

    public function forverification_list()
    {
        try {
            $user_details = User::join('user_details', 'user_details.user_id', 'users.id')
                                    ->where('users.profile_id', null)
                                    ->get();

            $dt = DataTables::of($user_details);
            return $dt->make(true);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function setProfile_id(Request $request)
    // {
    //     try {
    //         $user->update(['profile_id' => $request->input]);
    //         return response()-json(['error'=> false, 'message' => "Successfully set profile."]);
    //     } catch (\Throwable $th) {
    //         return response()-json(['error'=> true, 'message' => $th->getMessage()]);
    //     }
    // }

}
