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


    public function index()
    {

        $mode = Auth::user()->mode;
        $profile = Auth::user()->profile;

        $role = \Auth::user()->getAllNavigation()->get();

        if($mode == null && $profile == null){

            return view('profiles.enrollment');

        }
        else {
            $title = ucwords(Auth::user()->name);
            $title_subheading  = ucwords($role[0]->mode . " : " . $role[0]->profile);
            $title_icon = 'home';
    
            $active_slug = "";
    
            $profile_menu = self::getProfileMenuLinks($role[0]->mode, $role[0]->profile);
    
            $profile_direct_links = self::getProfileMenuDirectLinks($role[0]->mode, $role[0]->profile);
                
            $program_direct_links = self::getProgramMenuDirectLinks($role[0]->mode, $role[0]->profile);
    
            
            return view('profiles.' . $role[0]->mode . '.index', 
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


        $path = explode('/', $show);

        $mode = Auth::user()->mode;
        $profile = Auth::user()->profile;

        // if (\Auth::check()) {
            $role = \Auth::user()->getAllNavigation()->get();
        // }

// FIX USER CONTROLLER


        // LIMIT TWO LEVELS OF SLUGS FOR PAGES
        // USE THIRD SLUG LEVEL AS PARAMETER
        if(count($path) >= 3){
            $show = $path[0]."/".$path[1];
        }
        
            $slug_info = Slug::where([
                ['mode', '=', $role[0]->mode],
                ['profile', '=', $role[0]->profile],
                ['slug', '=', $show]
            ])
            ->get();

            // dd($slug_info);

            if(count($role)>0){
                if(count($path) >= 3){
                    $view = $slug_info[0]['view'] . "_param";
                    $title = $path[2];
                } else {
                    $view = $slug_info[0]['view'];
                    $title = $slug_info[0]['title'];
                }

                $title_subheading  = $slug_info[0]['title_subheading'];
                $title_icon = $slug_info[0]['title_icon'];
            
            } else {
                $title = "Not Found : "  . $path[0] . "/" . $path[1] . " : " . $show;
                $title_subheading  = "Link not available in your profile or still under construction";
                $title_icon = 'home';
                $view = 'profiles.' . $role[0]->mode . '.index';
            }


            $active_slug = $show;

            $profile_menu = self::getProfileMenuLinks($role[0]->mode, $role[0]->profile);

            $profile_direct_links = self::getProfileMenuDirectLinks($role[0]->mode, $role[0]->profile);
            
            $program_direct_links = self::getProgramMenuDirectLinks($role[0]->mode, $role[0]->profile);

            
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


    private function getProfileMenuLinks($mode, $profile){

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

    private function getProfileMenuDirectLinks($mode, $profile){

        $profile_direct_links = UserProfileMainMenu::select('*')
            ->where([
                ['mode', '=', $mode],
                ['profile', '=', $profile],
                ['level_one', '=', 'profile_menu']
            ])
            ->get();

        // $profile_direct_links = \Auth::user()->getAllNavigation()
        //     ->where('roles.profile', $profile)
        //     ->where('roles.mode', $mode)
        //     ->where('permissions.level_one', 'profile_menu')
        //     ->get();

        return $profile_direct_links;

    }

    private function getProgramMenuDirectLinks($mode, $profile){

        $program_direct_links = UserProfileMainMenu::select('*')
            ->where([
                ['mode', '=', $mode],
                ['profile', '=', $profile],
                ['level_one', '=', 'program_menu']
            ])
            ->get();

        // $program_direct_links = \Auth::user()->getAllNavigation()
        //     ->where('roles.profile', $profile)
        //     ->where('roles.mode', $mode)
        //     ->where('permissions.level_one', 'program_menu')
        //     ->get();
        
        return $program_direct_links;

    }




}
