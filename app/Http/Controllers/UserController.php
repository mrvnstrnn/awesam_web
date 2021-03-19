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

        $profile_menu = Slug::where([
            ['mode', '=', $mode],
            ['profile', '=', $profile]
        ])->get();


        $profile_direct_links = UserProfileMainMenu::select('*')
            ->where([
                ['mode', '=', $mode],
                ['profile', '=', $profile]
            ])
            ->get();

        
        return view('profiles.' . $mode . '.index', 
            compact(
                'mode',
                'profile',
                'profile_menu',
                'profile_direct_links',
                'title', 
                'title_subheading', 
                'title_icon'
            )
        );
    }


    // View Show Router
    // Should be profile dependent

    public function show($show = null){


        $path = explode('/', $show);

        $mode = Auth::user()->mode;
        $profile = Auth::user()->profile;


        $slug_info = Slug::where([
                ['mode', '=', $mode],
                ['profile', '=', $profile],
                ['slug', '=', $show]
            ])->get();

        if(count($slug_info)>0){

            $title = $slug_info[0]['title'];
            $title_subheading  = $slug_info[0]['title_subheading'];
            $title_icon = $slug_info[0]['title_icon'];

            $view = $slug_info[0]['view'];
    
        } else {

            $title = "Not Found";
            $title_subheading  = "Link not available in your profile or still under construction";
            $title_icon = 'home';

            $view = 'profiles.' . $mode . '.index';
        }

        $profile_menu = Slug::where([
            ['mode', '=', $mode],
            ['profile', '=', $profile]
        ])->get();


        $profile_direct_links = UserProfileMainMenu::select('*')
            ->where([
                ['mode', '=', $mode],
                ['profile', '=', $profile]
            ])
            ->get();

        return view($view, 
            compact(
                'mode',
                'profile',
                'profile_menu',
                'profile_direct_links',
                'title', 
                'title_subheading', 
                'title_icon'
            )
        );


    }


}
