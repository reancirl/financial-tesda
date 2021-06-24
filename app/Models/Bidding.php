<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function purchase_request()
    {
    	return $this->belongsTo('App\Models\PurchaseRequest');
    }

    public function supplier_one()
    {
    	return $this->belongsTo('App\Models\Supplier','supplier_one_id','id');
    }

    public function supplier_two()
    {
    	return $this->belongsTo('App\Models\Supplier','supplier_two_id','id');
    }

    public function supplier_three()
    {
    	return $this->belongsTo('App\Models\Supplier','supplier_three_id','id');
    }

    public function items()
    {
    	return $this->hasMany('App\Models\BiddingItem');
    }
}
