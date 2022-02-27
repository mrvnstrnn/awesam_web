<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrMemoTableRenewal extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'pr_memo_table_renewal';

    protected $fillable = ['po_number', 'po_date', 'vendor', 'generated_pr_memo', 'status'];
}
