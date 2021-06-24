<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    public function pr_item()
    {
    	return $this->belongsTo('App\Models\PurchaseRequestItem','purchase_request_item_id','id');
    }
}
