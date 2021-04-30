<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\UserDetail;

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
        'role_id',
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
                $rolePermission = RolePermission::where('role_id', \Auth::user()->role_id)
                        ->where('permission_id', $permission->id)
                        ->first();

                if(!is_null($rolePermission)){
                    $collection->push($rolePermission);
                }
            }
            
            return count($collection->all()) > 0 ? true : false;
        }
    }

    public function getAllNavigation()
    {
        return RolePermission::join('permissions', 'permissions.id', 'role_permissions.permission_id')
                                        ->join('roles', 'roles.id', 'role_permissions.role_id')
                                        ->where('role_permissions.role_id', \Auth::user()->role_id);
                                        // ->get();
    }

    public function getUserRole()
    {
        return Role::find(\Auth::user()->role_id);
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
        return Role::get();
    }
}
