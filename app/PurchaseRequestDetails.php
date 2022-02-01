<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetails extends Model
{
    protected $table = 'purchase_request_details';

    protected $fillable = [
        'pr_id', 'product', 'qty'
    ];
}
