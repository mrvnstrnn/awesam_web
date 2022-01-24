<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Validator;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserProgram;
use App\Models\Permission;
use App\Models\UserDetail;
use App\Models\ProfilePermission;
use Log;

class ProfileController extends Controller
{
    public function all_profile()
    {
        $profiles = Profile::get();

        $dt = DataTables::of($profiles)
                    ->addColumn('action', function($row){
                        $route = route('edit.profile', $row->id);
                        $btn = "<button class='btn btn-primary btn-sm edit_profile' data-href='".$route."' data-toggle='tooltip' title='Edit'><i class='pe-7s-note'></i></button>";
                        return $btn;
                    });
        
        $dt->rawColumns(['action']);
        return $dt->make(true);
    }
    
    public function all_permission()
    {
        $permissions = Permission::get();

        $dt = DataTables::of($permissions)
                    ->addColumn('action', function($row){
                        $route = route('edit.permission', $row->id);
                        $btn = "<button class='btn btn-primary btn-sm edit_permission' data-href='".$route."' data-toggle='tooltip' title='Edit'><i class='pe-7s-note'></i></button> ";
                        $btn .= "<button class='btn btn-danger btn-sm delete_permission' data-href='".$route."' data-toggle='tooltip' title='Edit'><i class='pe-7s-trash'></i></button>";
                        return $btn;
                    });
        
        $dt->rawColumns(['action']);
        return $dt->make(true);
    }

    public function edit_profile($id)
    {
        try {
            $profile = Profile::select('permissions.title', 'profiles.id as profile_id', 'profiles.profile', 'permissions.id')
                                    ->join('profile_permissions', 'profile_permissions.profile_id', 'profiles.id')
                                    ->join('permissions', 'permissions.id', 'profile_permissions.permission_id')
                                    ->where('profile_permissions.profile_id', $id)
                                    ->get();

            $permissions = Permission::get();
            if(count($profile) > 0){
                return response()->json(['error' => false, 'message' => $profile, 'permissions' => $permissions ]);
            } else {
                return response()->json(['error' => true, 'message' => 'No data found.' ]);
            }         
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }


    public function edit_permission(Permission $permission)
    {
        try {
            // $permissions = Permission::findOrFail($id);
            if(!is_null($permission)){
                return response()->json(['error' => false, 'message' => $permission ]);
            } else {
                return response()->json(['error' => true, 'message' => 'No data found.' ]);
            }         
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function update_profile(Request $request){
        try {
            $validate = Validator::make($request->all(), array(
                'profile_name' => 'required',
                'profile_checkbox' => 'required',
            ));

            if($validate->passes()){
                Profile::where('id', $request->input('hidden_id'))
                            ->update([
                                'profile' => $request->input('profile_name')
                            ]);
    
                ProfilePermission::where('profile_id', $request->input('hidden_id'))
                                        ->delete();
    
    
                for ($i=0; $i < count($request->input('profile_checkbox')); $i++) { 
                    ProfilePermission::create([
                        'profile_id' => $request->input('hidden_id'),
                        'permission_id' => $request->input('profile_checkbox')[$i],
                    ]);
                }
                
                
                return response()->json(['error' => false, 'message' => 'Successfully updated profile.' ]);
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function addupdate_permission(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), array(
                'title' => 'required',
                'title_subheading' => 'required',
                'menu' => 'required',
                'slug' => 'required',
                'level_one' => 'required',
                'level_two' => 'required',
                'icon' => 'required'
            ));

            if($validate->passes()){
                Permission::updateOrCreate(
                    ['id' => $request->input('hidden_permission_id')]
                    , $request->all()
                );

                if(is_null($request->input('hidden_permission_id'))){
                    return response()->json(['error' => false, 'message' => "Successfully added permission." ]);
                } else {
                    return response()->json(['error' => false, 'message' => "Successfully updated permission." ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => $validate->errors() ]);
            }
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function deletePermission(Request $request)
    {
        try {
            $permission = Permission::findOrFail($request->input('hidden_permission_id'));
            if(!is_null($permission)){
                $permission->delete();
                return response()->json(['error' => false, 'message' => "Successfully deleted permission" ]);
            } else {
                return response()->json(['error' => true, 'message' => 'No data found.' ]);
            }   
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_profile()
    {
        try {
            $profiles = Profile::get();
            return response()->json(['error' => false, 'message' => $profiles ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function assign_profile(Request $request)
    {
        try {

            if($request->input('profile_id') == 2 || $request->input('profile_id') == 3){
                $required = 'required';
            } else {
                $required = '';
            }
            $validate = \Validator::make($request->all(), array(
                'checkbox_id' => $required,
            ));

            if($validate->passes()){
                User::where('id', $request->input('user_id'))
                        ->update([
                            'profile_id' => $request->input('profile_id')
                        ]);

                if(!is_null($request->input('mysupervisor'))){
                    UserDetail::where('user_id', $request->input('user_id'))->update([
                        'IS_id' => $request->input('mysupervisor'),
                        'designation' => $request->input('profile_id'),
                    ]);
                } else {
                    UserDetail::where('user_id', $request->input('user_id'))->update([
                        'designation' => $request->input('profile_id'),
                    ]);
                }
    
                // if($request->input('profile_id') == 2){
                    for ($i=0; $i < count($request->input('checkbox_id')); $i++) { 
                        UserProgram::create([
                            "user_id" => $request->input('user_id'),
                            "program_id" => $request->input('checkbox_id')[$i],
                            "active" => $request->input('checkbox_id')[$i] == 0 ? 1 : "",
                        ]);
                    }
                // }
                return response()->json(['error' => false, 'message' => "Successfully assigned profile." ]);
            } else {
                return response()->json(['error' => true, 'message' => "Program required."]);
            }

            
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_supervisor()
    {
        try {

            $vendor = UserDetail::select('user_details.vendor_id')
                                            ->where('user_id', \Auth::id())
                                            ->first();

            $supervisors = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                    // ->where('user_details.IS_id', \Auth::id())
                                    ->where('users.profile_id', 3)
                                    ->where('user_details.vendor_id', $vendor->vendor_id)
                                    ->get();

            return response()->json(['error' => false, 'message' => $supervisors ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }

    public function get_agent(Request $request)
    {
        try {
            $agents = UserDetail::join('users', 'user_details.user_id', 'users.id')
                                ->where('user_details.IS_id', \Auth::id())
                                ->where('users.profile_id', 2)
            ->get();

            return response()->json(['error' => false, 'message' => $agents ]);
        } catch (\Throwable $th) {
            Log::channel('error_logs')->info($th->getMessage(), [ 'user_id' => \Auth::id() ]);
            return response()->json(['error' => true, 'message' => $th->getMessage() ]);
        }
    }
}
