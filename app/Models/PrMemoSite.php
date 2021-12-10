<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrMemoSite extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'pr_memo_site';

    protected $fillable = ['pr_memo_id', 'sam_id'];
}
