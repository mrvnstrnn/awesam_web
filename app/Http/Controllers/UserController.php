<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Slug;
use App\Models\UserProfileMainMenu;
use App\Models\RolePermission;
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
