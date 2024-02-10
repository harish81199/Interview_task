<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeeSales extends Model
{
    use HasFactory;
    protected $table = 'coffee_sales';
    protected $fillable = ['product','quantity','unit_cost','selling_price','profile_margin','shipping_cost','created_by'];
}
