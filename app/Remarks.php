<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    // protected $table = 'units';

    protected $fillable = [
        'id', 'rating', 'remark', 'user_id', 'pr_id'
    ];
}
