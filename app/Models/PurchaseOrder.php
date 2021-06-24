<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Models\Qualification');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function pr()
    {
        return $this->belongsTo('App\Models\PurchaseRequest','purchase_request_id',);
    }

    public function items()
    {
    	return $this->hasMany('App\Models\PurchaseOrderItem');
    }

    public function completed()
    {
    	return $this->hasMany('App\Models\PurchaseOrderItem')->where('status','Received');
    }

    public function status()
    {
    	return $this->hasMany('App\Models\PurchaseOrderItem')->where('status','!=','Pending');
    }
}
