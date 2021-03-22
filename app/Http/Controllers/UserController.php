<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Slug;
use App\Models\UserProfileMainMenu;
// use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
 
 
    // Main View For User
    // Should be profile dependent


    public function index()
    {

        $mode = Auth::user()->mode;
        $profile = Auth::user()->profile;

        $title = ucwords(Auth::user()->name);
        $title_subheading  = ucwords($mode . " : " . $profile);
        $title_icon = 'home';

        $active_slug = "";

        $profile_menu = self::getProfileMenuLinks($mode, $profile);

        $profile_direct_links = self::getProfileMenuDirectLinks($mode, $profile);
            
        $program_direct_links = self::getProgramMenuDirectLinks($mode, $profile);

        
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


    public function show($show = null){


        $path = explode('/', $show);

        $mode = Auth::user()->mode;
        $profile = Auth::user()->profile;


        // LIMIT TWO LEVELS OF SLUGS FOR PAGES
        // USE THIRD SLUG LEVEL AS PARAMETER
        if(count($path) >= 3){
            $show = $path[0]."/".$path[1];
        }



        $slug_info = Slug::where([
            ['mode', '=', $mode],
            ['profile', '=', $profile],
            ['slug', '=', $show]
        ])->get();

        if(count($slug_info)>0){



            if(count($path) >= 3){

                $view = $slug_info[0]['view'] . "_param";
                $title = $path[2];

            }
            else {

                $view = $slug_info[0]['view'];
                $title = $slug_info[0]['title'];

            }

            $title_subheading  = $slug_info[0]['title_subheading'];
            $title_icon = $slug_info[0]['title_icon'];

    
        } else {

            $title = "Not Found : "  . $path[0] . "/" . $path[1] . " : " . $show;
            $title_subheading  = "Link not available in your profile or still under construction";
            $title_icon = 'home';

            $view = 'profiles.' . $mode . '.index';
        }


        $active_slug = $show;

        $profile_menu = self::getProfileMenuLinks($mode, $profile);

        $profile_direct_links = self::getProfileMenuDirectLinks($mode, $profile);
            
        $program_direct_links = self::getProgramMenuDirectLinks($mode, $profile);

        
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

        $profile_menu = Slug::where([
            ['mode', '=', $mode],
            ['profile', '=', $profile]
        ])->get();

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
        
        return $program_direct_links;

    }




}
