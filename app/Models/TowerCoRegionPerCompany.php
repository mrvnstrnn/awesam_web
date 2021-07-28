<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TowerCoRegionPerCompany extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'towerco_region_totals_per_company';
}
