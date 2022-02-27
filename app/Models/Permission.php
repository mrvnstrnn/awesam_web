<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    protected $table = 'permissions';

    protected $fillable = ['title', 'title_subheading', 'menu', 'slug', 'level_one', 'level_two', 'level_three', 'icon' ];
}
