<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;
use App\Models\RolePermission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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
        if($checkPermission == 'team'){
            return true;
        }
        $permission = Permission::where('slug', $checkPermission)->first();

        if(is_null($permission)) {
            return false;
        } else {
            $rolePermission = RolePermission::where('role_id', \Auth::user()->role_id)
                    ->where('permission_id', $permission->id)
                    ->first();

            return !is_null($rolePermission) ? true : false;
        }
    }

    public function getAllNavigation()
    {
        return RolePermission::join('permissions', 'permissions.id', 'role_permissions.permission_id')
                                        ->join('roles', 'roles.id', 'role_permissions.role_id')
                                        ->where('role_permissions.role_id', \Auth::user()->role_id);
                                        // ->get();
    }
}
