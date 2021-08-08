<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsaLineItem extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'site_line_items';
    protected $fillable = ['sam_id', 'fsa_id'];
}
