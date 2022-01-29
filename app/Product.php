<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  
    protected $fillable = [
        'name', 'unit_price', 'details', 'vendor_id'
    ];
}
