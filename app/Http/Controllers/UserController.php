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
use App\Models\Profile;
use App\Models\Vendor;
use App\Models\UserProgram;
use DataTables;
use Carbon\Carbon;
use Log;

use Illuminate\Support\Facades\Hash;
use Validator;

use Illuminate\Support\Facades\Http;

// use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
 
 
    // Main View For User
    // Should be profile dependent

    public function my_profile()
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
                $title_icon = 'monitor';
        
                $active_slug = "my-profile";
        
                $profile_menu = self::getProfileMenuLinks();
    
                $profile_direct_links = self::getProfileMenuDirectLinks();
                    
                $program_direct_links = self::getProgramMenuDirectLinks();
                
                return view('my-profile', 
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
                    )
                );
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function draftable()
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
                $title_icon = 'monitor';
        
                $active_slug = "my-profile";
        
                $profile_menu = self::getProfileMenuLinks();
    
                $profile_direct_links = self::getProfileMenuDirectLinks();
                    
                $program_direct_links = self::getProgramMenuDirectLinks();

                //API Draftable

                $token = 'ef277522f8d24adb6f46805c790e1f15';
                $account_id = 'pxFvIM';

                $data = http_build_query(
                    [
                        'right' => [
                            "file_type" => "pdf",
                            "source_url" => "https://api.draftable.com/static/test-documents/paper/right.pdf"
                        ],
                        'left' => [
                            "file_type" => "pdf",
                            "source_url" => "https://api.draftable.com/static/test-documents/paper/left.pdf"
                        ]
                    ]
                );

                $opts = [
                    "http" => [
                        "method" => "GET",
                        "header" => "Accept-language: en\r\n".
                                    "Content-type: multipart/form-data\r\n".
                                    "Accept: application/json\r\n".
                                    "Authorization: Token " . $token,

                        "content" => [
                                'right.source_url' => "http://www.africau.edu/images/default/sample.pdf",
                                'right.file_type' => "pdf",
                                'left.source_url' => "http://www.africau.edu/images/default/sample.pdf",
                                'left.file_type' => "pdf",
                            ]
                    ]
                ];
                
                $context = stream_context_create($opts);

                // Get a list of all comparisons
                $comparisons = file_get_contents('https://api.draftable.com/v1/comparisons', false, $context);

                $collect = json_decode($comparisons);

                dd(json_decode($comparisons));

                // Create a signed viewer URL which expires next week.
                $valid_until = time() + (7 * 24 * 60 * 60); // Timestamp one week in the future.
                $identifier = end($collect->results)->identifier; // Take a specific comparison you want to view.

                $signature = hash_hmac('sha256', '{"account_id":"' . $account_id .'","identifier":"' . $identifier . '","valid_until":' . $valid_until . '}', $token);
                $signed_url =  'https://api.draftable.com/v1/comparisons/viewer/' . $account_id . '/' . $identifier;
                //API Draftable
                
                return view('draftable', 
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
                        'signed_url',
                    )
                );
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function laravel_curl ()
    {

        // $opts = [
        //     "http" => [
        //         "method" => "GET",
        //         "header" => "Content-Type: multipart/form-data Accept: application/json" ."Authorization: Token " . $token
        //     ],
        //     'identifier' => 'LtIqqWLR',
        //     'public' => false,
        //     'left' => [
        //         "file_type" => "pdf",
        //         "file" => "/files/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf"
        //     ],
        //     'right' => [
        //         "file_type" => "pdf",
        //         "file" => "/files1/1642955444renewal-000000009-loi-NONE-get-send-approved-loi-01.pdf",
        //     ],
        // ];

        $token = 'ef277522f8d24adb6f46805c790e1f15';
        $account_id = 'pxFvIM';

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => "Accept-language: en\r\n".
                            "Content-type: multipart/form-data\r\n".
                            "Accept: application/json\r\n".
                            "Authorization: Token " . $token,
            ]
        ];
          
        $context = stream_context_create($opts);

        // Get a list of all comparisons
        $comparisons = file_get_contents('https://api.draftable.com/v1/comparisons', false, $context);

        // Create a signed viewer URL which expires next week.
        $valid_until = time() + (7 * 24 * 60 * 60); // Timestamp one week in the future.
        $identifier = 'VctsMUfX'; // Take a specific comparison you want to view.

        $signature = hash_hmac('sha256', '{"account_id":"' . $account_id .'","identifier":"' . $identifier . '","valid_until":' . $valid_until . '}', $token);
        $signed_url =  'https://api.draftable.com/v1/comparisons/viewer/' . $account_id . '/' . $identifier . '?valid_until=' . $valid_until . '&signature=' . $signature;
        
        return response()->json(['error' => false, 'message' => $signed_url ]);
    }

    public function profile_switcher($profile_id)
    {
        try {
            User::where('id', \Auth::user()->id)
                    ->update([
                        'profile_id' => $profile_id
                    ]);
            
            return redirect('/');
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return abort(404, $th);
        }
    }

    public function onboarding()
    {
        $locations = \DB::table('location_regions')->get();
        if(is_null(\Auth::user()->getUserDetail()->first())){
            // $locate = Location::select('region');
            // $locations = $locate->groupBy('region')->get();

            $user_details = \Auth::user()->getUserDetail()->where('user_details.address_id', '!=', null)->first();
            return view('profiles.enrollment', compact('locations', 'user_details'));
        }
        if(is_null(\Auth::user()->profile_id)){

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
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
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
                $where = "region_id";
                $table = "location_provinces";
            } else if ($id == 'province') {
                $select = "lgu";
                $where = "province_id";
                $table = "location_lgus";
            } else {
                $select = 'lgu';
            }

            // $locate = Location::select($select)->where($id, $val);
            // $locate = Location::select($select)->where($id, $val);

            // $location = $locate->groupBy($select)->get();

            $location = \DB::table($table)->where($where, $val)->get();

            
            // return response()->json(['error' => true, 'message' => $location ]);
            return response()->json(['error' => false, 'message' => $location, 'new_id' => $select ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function finish_onboarding(Request $request)
    {
        try {
            $img = $request->input('capture_image');

            if (preg_match('/^data:image\/(\w+);base64,/', $img)) {
                $data = substr($img, strpos($img, ',') + 1);
            
                $data = base64_decode($data);
                $imageName = \Str::random(10).'.'.'png';

                \Storage::disk('local')->put($imageName, $data);

                // $path = \Storage::disk('local')->getAdapter()->getPathPrefix();
            } else {
                $imageName = $request->input('capture_image');
            }

            $profiles = Profile::find($request->input('designation'));

            
            // return response()->json(['error' => true, 'message' => $request->all() ]);

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

            if($validate->passes()) {

                if (is_null($request->input('hidden_province')) || is_null($request->input('hidden_lgu')) || is_null($request->input('hidden_region'))) {
                    return response()->json(['error' => true, 'message' => 'Address field id required.' ]);
                }
                
                // $mode = \Auth::user()->getUserProfile()->mode == "vendor" ? "" : "globe";
                // $address = Location::where('province', $request->input('hidden_province'))
                //                         ->where('lgu', $request->input('hidden_lgu'))
                //                         ->where('region', $request->input('hidden_region'))
                //                         ->first();
                                        
                $user_details = UserDetail::where('user_id', \Auth::user()->id)->first();
    
                if ($request->input('designation') == 1) {
                    User::where('id', \Auth::user()->id)
                            ->update([
                                'profile_id' => $request->input('designation'),
                            ]);
                }

                User::where('id', \Auth::user()->id)
                        ->update([
                            'middlename' => $request->input('middlename'),
                            'nickname' => $request->input('nickname'),
                            'suffix' => $request->input('suffix'),
                            'onboarded' => 1,
                            'profile_id' => $profiles->mode == "vendor" && $request->get('designation') != 1 ? null : $request->get('designation'),
                        ]);

                if(!is_null($user_details)){
                    UserDetail::where('user_id', \Auth::id())
                                ->update([
                                    // 'address_id' => $address->lgu_id,
                                    'mode' => $profiles->mode,
                                    'birthday' => $request->get('birthday'),
                                    'gender' => $request->get('gender'),
                                    'contact_no' => $request->get('contact_no'),
                                    'landline' => $request->get('landline'),
                                    'address' => $request->get('address'),
                                    'designation' => $request->get('designation'),
                                    'employment_classification' => $request->get('employment_classification'),
                                    'employment_status' => $request->get('employment_status'),
                                    'hiring_date' => $request->get('hiring_date'),
                                    'address_id' => $request->input('hidden_lgu'),
                                    'lgu_id' => $request->input('hidden_lgu'),
                                    'province_id' => $request->input('hidden_province'),
                                    'region_id' => $request->input('hidden_region'),
                                    'image' => $imageName,
                                ]);

                    return response()->json(['error' => false, 'message' => 'Success updated details.', 'mode' => $profiles->mode ]);
                } else {

                    $detail = new UserDetail();
                    $detail->address_id = $request->input('hidden_lgu');
                    $detail->mode = $profiles->mode;
                    $detail->user_id = \Auth::user()->id;
                    $detail->birthday = $request->get('birthday');
                    $detail->gender = $request->get('gender');
                    $detail->contact_no = $request->get('contact_no');
                    $detail->landline = $request->get('landline');
                    $detail->address = $request->get('address');
                    $detail->designation = $request->get('designation');
                    $detail->employment_classification = $request->get('employment_classification');
                    $detail->employment_status = $request->get('employment_status');
                    $detail->hiring_date = $request->get('hiring_date');
                    $detail->lgu_id = $request->get('hidden_lgu');
                    $detail->province_id = $request->get('hidden_province');
                    $detail->region_id = $request->get('hidden_region');
                    $detail->image = $imageName;

                    $detail->save();

                    return response()->json(['error' => false, 'message' => 'Success added details.', 'mode' => $profiles->mode ]);
                }

            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
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
        
                $active_slug = "transfer";
        
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
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function activities_agent($agent_id = null)
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
                $title_icon = 'monitor';
        
                $active_slug = "activities";
        
                $profile_menu = self::getProfileMenuLinks();
    
                $profile_direct_links = self::getProfileMenuDirectLinks();
                    
                $program_direct_links = self::getProgramMenuDirectLinks();
                
                return view('profiles.'.$mode.'.'.strtolower(str_replace(' ', '-', ucfirst($profile))).'.activities', 
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
                        'agent_id',
                    )
                );
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function index()
    {
        if(count(\Auth::user()->getUserDetail()->get()) < 1){
            return redirect('/onboarding');
        }
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
            if(count($path) >= 2){
                // $show = $path[0]."/".$path[1];
                $show = $path[0];
            }

            $role = \Auth::user()->getUserProfile();

                $mode = $role->mode;
                $profile = $role->profile;


            // $role = \DB::table('profiles')
            //             ->join('users', 'users.profile_id', 'profiles.id')
            //             ->where('users.id', \Auth::user()->id)
            //             ->get();
            
            // $mode = $role[0]->mode;
            // $profile = $role[0]->profile;

            $profile_for_view = strtolower(str_replace(' ', '-', ucfirst($profile)));

            $role = \Auth::user()->getAllNavigation()
                                    ->where('slug', $show)
                                    ->get();


            if(count($role)>0){
                if(count($path) >= 2){

                    // dd($path);

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

    public function daily_activity(Request $request){


        if(is_null(\Auth::user()->profile_id)){
            
            return redirect('/onboarding');

        } else {

            $role = \Auth::user()->getUserProfile();

            $mode = $role->mode;
            $profile = $role->profile;

            $profile_for_view = strtolower(str_replace(' ', '-', ucfirst($profile)));

            $view = 'profiles' . '.' .$mode. '.' .$profile_for_view. '.daily-activity';

            $title = ucwords(Auth::user()->name);
            $title_subheading  = ucwords($mode . " : " . $profile);
            $title_icon = 'home';

            $active_slug = 'daily-activity';

            $profile_menu = self::getProfileMenuLinks();
            $profile_direct_links = self::getProfileMenuDirectLinks();
            $program_direct_links = self::getProgramMenuDirectLinks();

            $user_id = $request->get('user_id');
            $agent_user_id = $request->get('agent_user_id');
            $region_data = $request->get('region');
            
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
                    'title_icon',
                    'user_id',
                    'agent_user_id',
                    'region_data'
                )
            );
        }

    }

    public function work_plan(Request $request){


        if(is_null(\Auth::user()->profile_id)){
            
            return redirect('/onboarding');

        } else {

            $role = \Auth::user()->getUserProfile();

            $mode = $role->mode;
            $profile = $role->profile;

            $profile_for_view = strtolower(str_replace(' ', '-', ucfirst($profile)));

            $view = 'profiles' . '.' .$mode. '.' .$profile_for_view. '.work-plan';

            $title = ucwords(Auth::user()->name);
            $title_subheading  = ucwords($mode . " : " . $profile);
            $title_icon = 'home';

            $active_slug = 'work-plan';

            $profile_menu = self::getProfileMenuLinks();
            $profile_direct_links = self::getProfileMenuDirectLinks();
            $program_direct_links = self::getProgramMenuDirectLinks();

            $user_id = $request->get('user_id');
            $agent_user_id = $request->get('agent_user_id');
            $region_data = $request->get('region');

            // dd($region_data);
            
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
                    'title_icon',
                    'user_id',
                    'agent_user_id',
                    'region_data'
                )
            );
        }

    }


    private function getProfileMenuLinks(){
        $profile_menu = \Auth::user()->getAllNavigation()
            ->orderBy('menu_sort', 'asc')
            ->orderBy('menu', 'asc')
            ->get();

        // return $profile_menu->groupBy('level_two');
        return $profile_menu;

    }

    private function getProfileMenuDirectLinks(){
        $profile_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('level_one', 'profile_menu')
                                            ->orderBy('menu_sort', 'asc')
                                            ->get();

        return $profile_direct_links->groupBy('level_two');

    }

    private function getProgramMenuDirectLinks(){
        $program_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('level_one', 'program_menu')
                                            ->orderBy('menu_sort', 'asc')
                                            ->get();

                
        
        return $program_direct_links->groupBy('level_two');
    }

    public function forverification_list()
    {
        try {
            $vendor = UserDetail::select('user_details.vendor_id')
                        ->where('user_id', \Auth::id())
                        ->first();

            if (isset($vendor->vendor_id)) {
                $user_details = \DB::table('users')
                    ->join('user_details', 'user_details.user_id', 'users.id')
                    ->join('profiles', 'user_details.designation', 'profiles.id')
                    ->where('users.profile_id', null)
                    ->where('user_details.vendor_id', $vendor->vendor_id)
                    // ->where('user_details.IS_id', \Auth::id())
                    ->get();
            } else {
                $user_details = \DB::table('users')
                    ->join('user_details', 'user_details.user_id', 'users.id')
                    ->join('profiles', 'user_details.designation', 'profiles.id')
                    ->where('users.profile_id', null)
                    // ->where('user_details.IS_id', \Auth::id())
                    ->get();
            }
            

            $dt = DataTables::of($user_details);
                            // ->addColumn('status', function($row){
                            //     return is_null($row->profile_id) ? "<div class='badge badge-warning'>Pending</div>" : "<div class='badge badge-success'>Onboarded</div>";                            
                            // });
                            
            // $dt->rawColumns(['status']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function forpendingonboarding_list()
    {
        try {
            $is_vendor = UserDetail::select('vendor_id')->where('user_id', \Auth::id())->first();

            $user_details = \DB::table('invitations')
                ->select('invitations.firstname', 'invitations.lastname', 'invitations.email')
                ->leftjoin('users', 'users.email', 'invitations.email')
                ->where('invitations.company_id', $is_vendor->vendor_id)
                ->whereNull('users.email')
                ->get();

            $dt = DataTables::of($user_details);
                            // ->addColumn('status', function($row){
                            //     return is_null($row->profile_id) ? "<div class='badge badge-warning'>Pending</div>" : "<div class='badge badge-success'>Onboarded</div>";                            
                            // });
                            
            // $dt->rawColumns(['status']);
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function register_user(Request $request)
    {
        try {
            $validate = \Validator::make($request->all(), array(
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', 
                    'confirmed'
                ],
            ));

            // dd($request->all());

            if($validate->passes()){
                Invitation::where('token', $request->input('token_hidden'))
                    ->where('invitation_code', $request->input('invitationcode_hidden'))
                    ->update(['use' => 1]);

                $user = User::create([
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'name' => $request->input('firstname') . ' ' . $request->input('lastname'),
                    'email' => $request->input('email'),
                    'role_id' => 7,
                    'email_verified_at' => Carbon::now()->toDate(),
                    'password' => Hash::make($request->input('password')),
                ]);

                $is = User::where('email', $request->input('is_hidden'))->first();
                $vendor = Vendor::where('vendor_id', $request->input('company_hidden'))->first();

                $user_details = new UserDetail();
                $user_details->user_id = $user->id;
                $user_details->mode = $request->input('mode');
                $user_details->IS_id = $is->id;
                $user_details->vendor_id = $vendor->vendor_id;
                $user_details->save();

                \Auth::login($user);
                return redirect('/');
            } else {
                return redirect('/invitation-link/' .$request->get('token_hidden'). '/' .$request->get('invitationcode_hidden'))
                            ->withErrors($validate)
                            ->withInput();
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function view_assigned_site($sam_id)
    {

        $site = \DB::table('site')
                        ->where('site.sam_id', "=", $sam_id)
                        ->get();

        // dd($site);

        $agent = json_decode($site[0]->site_agent);
        $agent = $agent[0];
        $agent_name = $agent->firstname . " " .$agent->middlename . " " . $agent->lastname . " " . $agent->suffix;
                
        $agent_sites = \DB::table('site')
                        ->select('site.sam_id', 'site.site_name')
                        ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                        ->where('agent_id', '=', $agent->user_id)
                        ->get();

        // dd($agent_sites);


        $array = json_decode($site[0]->sub_activity);        
        $res = array();
        foreach ($array as $each) {
            if (isset($res[$each->activity_id])){
                array_push($res[$each->activity_id], $each );
            }
            else{
                $res[$each->activity_id] = array($each);
            }
        }

        $sub_activities = $res;
        $what_site = $site[0];


        $array = json_decode($site[0]->timeline);        
        $res = array();

        // dd($array);

        // $what_count = 0;

        foreach ($array as $each) {
            // $what_count++;

            if (isset($res[$each->stage_name])){

                array_push($res[$each->stage_name],  array("stage_id" => $each->stage_id, "stage_name" => $each->stage_name, "activity_id" => $each->activity_id, "activity_name" => $each->activity_name,"start_date" => $each->start_date, "end_date" => $each->end_date, "activity_complete" => $each->activity_complete));

            }
            else{
                $res[$each->stage_name] = array( array("stage_id" => $each->stage_id, "stage_name" => $each->stage_name, "activity_id" => $each->activity_id, "activity_name" => $each->activity_name, "start_date" => $each->start_date, "end_date" => $each->end_date, "activity_complete" => $each->activity_complete));
            }

            // if($each->profile_id == 2){

            // }

        }


        $activities = array();



        $activity_count = 0;
        $done_activity_count = 0;

        foreach($res as $re){

            foreach($re as $r){

                $activity_count++;
                
                if($r['activity_complete'] === 'true'){
                    $color = "success";
                    $badge = "DONE";

                    $done_activity_count++;

                } else {

                    if($r['activity_complete'] === 'false'){
                        $color = "primary";
                        $badge = "ACTIVE TASK";
                    } else {
                        if(date('Y-m-d') < date($r['start_date'])){
                            $color = "secondary";
                            $badge = "UPCOMING";
                        } else {
                            if(date('Y-m-d') < date($r['end_date'])){
                                $color = "warning";
                                $badge = "ON SCHEDULE";
                            } else {
                                $color = "danger";
                                $badge = "DELAYED";
                            }
        
                        }        
                    }

                }

                if(array_key_exists($r['activity_id'], $sub_activities)==true){
                    $what_subactivities = $sub_activities[$r['activity_id']];
                } else {
                    $what_subactivities = [];
                }

                array_push($activities,  
                    array(
                        "activity_name" => $r['activity_name'],  
                        "activity_id" => $r['activity_id'],  
                        "activity_complete" => $r['activity_complete'], 
                        "start_date" => $r['start_date'], 
                        "end_date" => $r['end_date'], 
                        "sub_activities" => $what_subactivities,
                        "color" => $color,
                        "badge" => $badge
                    )
                );

            }
        }

        $completed_activities = $done_activity_count / $activity_count;

        // dd($what_count);

        $timeline = array();
    
        foreach($res as $re){
            $first = array_key_first($re);
            $last = array_key_last($re);
    
            $first =$re[$first]["start_date"];
            $last = ($re[$last]["end_date"]);
            $key = key($res);
    
            next($res);
            array_push($timeline, array("stage_name" => $key, "start_date" => $first, "end_date" => $last ));
        }
    
        $timeline = json_encode($timeline);



        $array = json_decode($site[0]->sub_activity);        
        $res = array();
        foreach ($array as $each) {
            if (isset($res[$each->activity_id])){
                array_push($res[$each->activity_id], $each );
            }
            else{
                $res[$each->activity_id] = array($each);
            }
        }


        $site_fields = json_decode($site[0]->site_fields);

        $role = \Auth::user()->getAllNavigation()
                                ->get();

        $mode = $role[0]->mode;
        $profile = $role[0]->profile;
        $profile = strtolower(str_replace(' ', '-', ucfirst($profile)));

        // $mode = "vendor";
        // $profile = "supervisor";

        $active_slug = "assigned-sites";
        $title = $site[0]->site_name;
        $title_subheading = $sam_id;
        $title_icon = "box2";

        $profile_menu = self::getProfileMenuLinks();
        $profile_direct_links = self::getProfileMenuDirectLinks();
        $program_direct_links = self::getProgramMenuDirectLinks();

        $view = "profiles." . $mode . "." . $profile . ".view_site";        

        return view($view, 
            compact(
                'site',
                'timeline',
                'activities',
                'site_fields',
                'agent_name',
                'agent_sites',
                'what_site',
                'mode',
                'profile',
                'active_slug',
                'profile_menu',
                'profile_direct_links',
                'program_direct_links',
                'title', 
                'title_subheading', 
                'title_icon',
                'completed_activities'
            )
        );

    }

    public function my_calendar()
    {
        try {
            $arrayTimeline = collect();
            
            $timelines = \DB::table('site')
                            ->select('site.timeline', 'site.site_name')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->where('agent_id', '=', \Auth::id())
                            ->get();

            foreach ($timelines as $timeline) {
                // $arrayTimeline->push($timeline->timeline);
                $arrayTimeline->push($timeline);
            }

            // dd($timelines[0]->timeline);

            return response()->json([ "error" => false, "message" => $timelines ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th->getMessage();
        }

        // dd($timelines[0]->timeline);
    }

    public function my_calendar_activities()
    {
        try {
            $arrayTimeline = collect();
            
            $timelines = \DB::table('site')
                            ->select('site.timeline', 'site.site_name')
                            ->join('site_users', 'site_users.sam_id', 'site.sam_id')
                            ->where('agent_id', '=', \Auth::id())
                            ->get();

            foreach ($timelines as $timeline) {
                // $arrayTimeline->push($timeline->timeline);
                $arrayTimeline->push($timeline);
            }

            // dd($timelines[0]->timeline);

            return response()->json([ "error" => false, "message" => $timelines ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th->getMessage();
        }

        // dd($timelines[0]->timeline);
    }

    public function upload_image_file(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'file' => 'required',
            ));
            
            if($validate->passes()){
                if($request->hasFile('file')) {
    
                    $destinationPath = 'files/';
                
                    $extension = $request->file('file')->getClientOriginalExtension();
            
                    $fileName = time().$request->file('file')->getClientOriginalName();

                    $request->file('file')->move($destinationPath, $fileName); 
                    
                    return response()->json(['error' => false, 'message' => "Successfully uploaded a file.", "file" => $fileName]);
            
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors()->all()]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function notifications()
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
                $title_icon = 'monitor';
        
                $active_slug = "notifications";
        
                $profile_menu = self::getProfileMenuLinks();
    
                $profile_direct_links = self::getProfileMenuDirectLinks();
                    
                $program_direct_links = self::getProgramMenuDirectLinks();
                
                return view('profiles.notifications', 
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
                    )
                );
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function read_notifications ($id, $action)
    {
        try {
            \DB::table("notifications")
                                    ->where("id", $id)
                                    ->update([
                                        'read_at' => $action == "unread" ? null : Carbon::now(),
                                    ]);

            return response()->json(['error' => false, 'message' => "Successfully ".$action." notification." ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function update_profile_data (Request $request)
    {
        try {
            if ($request->input('form_type') == 'security') {

                $validate = Validator::make($request->all(), array(
                    'old_password' => 'required',
                    'password' => [
                        'required', 
                        'min:8', 
                        'confirmed:confirm-password', 
                        'different:old_password', 
                        'regex:/[a-z]/',
                        'regex:/[A-Z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*#?&]/', 
                    ],
                ));

                if ($request->input('old_password') && !Hash::check($request->input('old_password'), \Auth::user()->password)) {
                    $validate->errors()->add('old_password', 'Old password not valid');
                    return response()->json(['error' => true, 'message' => $validate->errors()->add('old_password', 'Old password not valid') ]);
                }

                if ($validate->passes()) {
                    User::where('id', \Auth::user()->id)
                        ->update([
                            'password' => Hash::make($request->input('password')),
                        ]);
                
                    return response()->json(['error' => false, 'message' => "Successfully updated password." ]);
                } else {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                }
            } else if ($request->input('form_type') == 'personal') {
                $validate = Validator::make($request->all(), array(
                    'birthday' => 'required',
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'contact_no' => 'required',
                    'landline' => 'required',
                ));

                if ($validate->passes()) {
                    User::where('id', \Auth::user()->id)
                        ->update([
                            'name' => $request->input('firstname') . " " .$request->input('lastname'),
                            'firstname' => $request->input('firstname'),
                            'lastname' => $request->input('lastname'),
                        ]);

                    UserDetail::where('user_id', \Auth::user()->id)
                    ->update([
                        'birthday' => $request->input('birthday'),
                        'contact_no' => $request->input('contact_no'),
                        'landline' => $request->input('landline'),
                    ]);
                
                    return response()->json(['error' => false, 'message' => "Successfully updated personal details." ]);
                } else {
                    return response()->json(['error' => true, 'message' => $validate->errors() ]);
                }
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_all_users ()
    {
        try {
            
                // 'users.email', 'users.name', 'users.id', 'users.onboarded', \DB::raw('(SELECT user_programs.program_id FROM user_programs WHERE user_programs.user_id = users.id) as user_id_programs'))

            $users = User::select('users.email', 'users.name', 'users.id', 'users.onboarded')
                        ->join('user_details', 'user_details.user_id', 'users.id')
                        ->get();

            $dt = DataTables::of($users)
                    ->addColumn('action', function($row){
                        $btn = '<button class="btn btn-lg btn-primary edit_user" type="button" data-id="'.$row->id.'">Edit</button>';
                        return $btn;
                    })
                    ->addColumn('program', function($row){
                        $programs = UserProgram::select('program.program')
                                            ->join('program', 'program.program_id', 'user_programs.program_id')
                                            ->where('user_programs.user_id', $row->id)
                                            ->get()
                                            ->pluck('program');
                        
                        return $programs;
                    })
                    ->addColumn('status', function($row){
                        return $row->onboarded == 0 ? "Not yet onboard" : "Onboarded";              
                    });
                            
            $dt->rawColumns(['action']);
            return $dt->make(true);

        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function add_new_user (Request $request)
    {
        try {

            $required_unique = "";
                
            if (is_null($request->get('id'))) {
                $required_unique = "unique:users";
            }
            
            $validate = Validator::make($request->all(), array(
                'firstname' => ['required'],
                'lastname' => ['required'],
                'email' => ['required', $required_unique],
                'profile' => ['required'],
            ));

            if ($validate->passes()) {

                $profile = Profile::find($request->get('profile'));

                $user = User::updateOrCreate([
                            'id'   => $request->get('id'),
                        ], [
                            'firstname' => $request->get('firstname'),
                            'lastname' => $request->get('lastname'),
                            'name' => $request->get('firstname') . " " .$request->get('lastname'),
                            'email' => $request->get('email'),
                            'password' => Hash::make("12345678"),
                            'email_verified_at' => Carbon::now(),
                        ]);

                if (is_null($request->get('id'))) {
                    
                    for ($i=0; $i < count($request->get('program')); $i++) { 
                        UserProgram::create([
                            'user_id' => $user->id,
                            'program_id' => $request->get('program')[$i],
                        ]);
                    }

                    UserDetail::create([
                        'vendor_id' => $request->get('vendor'),
                        'user_id' => $user->id,
                        'mode' => $profile->mode,
                        'designation' => $profile->id,
                    ]);
                } else {
                    
                    UserDetail::where('user_id', $request->get('id'))
                    ->update([
                        'vendor_id' => $request->get('vendor'),
                        'user_id' => $user->id,
                        'mode' => $profile->mode,
                        'designation' => $profile->id,
                    ]);
                }

                
                return response()->json(['error' => false, 'message' => "Successfully added user." ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_data_user (Request $request)
    {
        try {
            $users = User::where('id', $request->get('id'))
                        ->first();

            $programs = UserProgram::select('program.program_id')
                                ->join('program', 'program.program_id', 'user_programs.program_id')
                                ->where('user_programs.user_id', $request->get('id'))
                                ->get();

            return response()->json(['error' => false, 'message' => $users, 'programs' => $programs ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }

    public function get_users_report()
    {
        try {
            $users_report = \DB::table('view_users_per_vendor')->get();

            $dt = DataTables::of($users_report);
            
            return $dt->make(true);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            throw $th;
        }
    }

    public function login_as ($email)
    {
        $user = User::where('email', $email)
                    ->first();

        Auth::loginUsingId($user->id, true);
        return redirect()->to('/');
    }
}
