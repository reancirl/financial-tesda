<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public function cart_item()
    {
    	return $this->belongsTo('App\Models\CartItem','cart_item_id','id');
    }

    public function purchase_request()
    {
    	return $this->belongsTo('App\Models\PurchaseRequest');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','updated_by','id');
    }

    public function bidding_item()
    {
        return $this->hasOne('App\Models\BiddingItem','purchase_request_item_id','id');
    }
}
