<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiddingItem extends Model
{
    use HasFactory;

    public $guarded = [];

    public function pr_item()
    {
    	return $this->belongsTo('App\Models\PurchaseRequestItem','purchase_request_item_id','id');
    }
}
