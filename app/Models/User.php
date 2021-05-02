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

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

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
        return ProfilePermission::join('permissions', 'permissions.id', 'profile_permissions.permission_id')
                                        ->join('profiles', 'profiles.id', 'profile_permissions.profile_id')
                                        ->where('profile_permissions.profile_id', \Auth::user()->profile_id);
                                        // ->get();
    }

    public function getUserProfile()
    { 
        return Profile::find(\Auth::user()->profile_id);
    }

    public function getUserDetail()
    {
        return UserDetail::join('users', 'users.id', 'user_details.user_id')->where('user_details.user_id', \Auth::user()->id);
    }


    public function getCompany($id)
    {
        return Company::find($id);
    }

    public function allRoles()
    {
        return Profile::get();
    }
}
