<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrMemoTable extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'pr_memo_table';

    protected $fillable = ['budget_source', 'generated_pr_memo', 'date_created', 'department', 'division', 'from', 'to', 'group', 'recommendation', 'requested_amount', 'subject', 'thru', 'file_name', 'user_id', 'vendor_id', 'status' ];
}
