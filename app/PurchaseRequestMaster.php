<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestMaster extends Model
{
    protected $table = 'puchase_request_master';

    protected $fillable = [
        'pr_id', 'special_ordering_instructions', 'shipping_instructions', 'request_by', 'status'
    ];
}
