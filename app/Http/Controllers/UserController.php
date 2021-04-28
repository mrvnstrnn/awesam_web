<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Slug;
use App\Models\UserProfileMainMenu;
use App\Models\RolePermission;
use App\Models\Invitation;
use App\Models\Company;
use Validator;

use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
 
 
    // Main View For User
    // Should be profile dependent

    public function onboarding()
    {
        if(is_null(\Auth::user()->role_id)){
            return view('profiles.enrollment');
        } else {
            return redirect('/');
        }
    }

    public function invitation_registration ($token, $invitation_code)
    {
        $invitations = Invitation::join('companies', 'companies.id', 'invitations.company_id')
                                    ->where('invitations.token', $token)
                                    ->where('invitations.invitation_code', $invitation_code)
                                    ->first();

        return view('profiles.registration', compact(
            'invitations'
        ));
    }

    // public function invitation()
    // {
    //     $role = \Auth::user()->getAllNavigation()->get();
    //     $mode = $role[0]->mode;
    //     $profile = $role[0]->profile;
    //     $active_slug = "invite.employee";

    //     $title = ucwords(Auth::user()->name);
    //     $title_subheading  = ucwords($mode . " : " . $role[0]->profile);
    //     $title_icon = 'paper-plane';

    //     $profile_menu = self::getProfileMenuLinks();

    //     $profile_direct_links = self::getProfileMenuDirectLinks();
            
    //     $program_direct_links = self::getProgramMenuDirectLinks();
    //     return view('profiles.vendor.invite', compact(
    //         'mode',
    //         'profile',
    //         'active_slug',
    //         'profile_menu',
    //         'profile_direct_links',
    //         'program_direct_links',
    //         'title', 
    //         'title_subheading', 
    //         'title_icon'
    //     ));
    // }

    public function send_invitation(Request $request)
    {
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i <= 12; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $validate = Validator::make($request->all(), array(
                'email' => 'required|email',
                'firstname' => 'required | max:255',
                'lastname' => 'required | max:255',
            ));
            
            $token = sha1(time());

            if($validate->passes()){
                $company = Company::where('id', $request->input('company'))->first();

                if(is_null($company)){
                    return response()->json(['error' => true, 'message' =>"No company found."]);
                }

                $useCheck = Invitation::where('mode', $request->input('mode'))
                                            ->where('company_id', $request->input('company'))
                                            ->where('email', $request->input('email'))
                                            ->first();

                if(is_null($useCheck)){
                    Invitation::create([
                        'invitation_code' => $randomString,
                        'mode' => $request->input('mode'),
                        'company_id' => $request->input('company'),
                        'firstname' => $request->input('firstname'),
                        'lastname' => $request->input('lastname'),
                        'email' => $request->input('email'),
                        'token' => $token
                    ]);

                    $url = route('invite.link', [ $token, $randomString]);

                    $name = $request->input('firstname') . ' ' . $request->input('lastname');

                    $email = $request->input('email');

                    Mail::to($email)->send(new InvitationMail($url, $name, $company->company_name));
                    
                    return response()->json(['error' => false, 'message' => 'Invitation link has been sent.']);
                } else {
                    return response()->json(['error' => true, 'message' => $request->input('email') . ' already invited.']);
                }
            }
            return response()->json(['error' => true, 'message' => $validate->errors()->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }


    public function index()
    {
        if(is_null(\Auth::user()->role_id)){
            return redirect('/onboarding');
        } else {
            $role = \Auth::user()->getAllNavigation()->get();
            $mode = $role[0]->mode;
            $profile = $role[0]->profile;
            
            $title = ucwords(Auth::user()->name);
            $title_subheading  = ucwords($mode . " : " . $role[0]->profile);
            $title_icon = 'home';
    
            $active_slug = "";
    
            $profile_menu = self::getProfileMenuLinks();

            $profile_direct_links = self::getProfileMenuDirectLinks();
                
            $program_direct_links = self::getProgramMenuDirectLinks();
    
            
            return view('profiles.' . $mode . '.index', 
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

        if(is_null(\Auth::user()->role_id)){
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

            if(count($role)>0){
                if(count($path) >= 3){
                    $view = $slug_info[0]['view'] . "_param";
                    $title = $path[2];
                } else if (count($path) == 2) {
                    $title = $role[0]->title;
                    $view = 'profiles' . '.' .$mode. '.index';
                } else {
                    $title = $role[0]->title;
                    $view = 'profiles' . '.' .$mode. '.' .end($path);
                }

                $title_subheading  = $role[0]->title_subheading;
                $title_icon = $role[0]->icon;
            
            } else {
                $title = "Not Found : "  . $path[0] . "/" . $path[1] . " : " . $show;
                $title_subheading  = "Link not available in your profile or still under construction";
                $title_icon = 'home';
                $view = 'profiles.' . $mode . '.index';
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

        // $profile_menu = Slug::where([
        //         ['mode', '=', $mode],
        //         ['profile', '=', $profile]
        //     ])
        //     ->orderBy('level_two', 'asc')
        //     ->orderBy('menu', 'asc')
        //     ->get();

        $profile_menu = \Auth::user()->getAllNavigation()
            ->orderBy('level_two', 'asc')
            ->orderBy('menu', 'asc')
            ->get();

        return $profile_menu;

    }

    private function getProfileMenuDirectLinks(){
        // $profile_direct_links = UserProfileMainMenu::select('*')
        //     ->where([
        //         ['mode', '=', $mode],
        //         ['profile', '=', $profile],
        //         ['level_one', '=', 'profile_menu']
        //     ])
        //     ->get();

        $profile_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('permissions.level_one', 'profile_menu')
                                            ->get();

        return $profile_direct_links->groupBy('level_two');

    }

    private function getProgramMenuDirectLinks(){
        $program_direct_links = \Auth::user()->getAllNavigation()
                                            ->where('permissions.level_one', 'program_menu')
                                            ->get();
        
        return $program_direct_links->groupBy('level_two');
    }

}
