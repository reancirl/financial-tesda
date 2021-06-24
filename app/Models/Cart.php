<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $guarded = [];

    public function scopeActive($query, $user_id)
    {
	    return $query->where('user_id',$user_id)->where('is_checkout',0);    		
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function items()
    {
    	return $this->hasMany('App\Models\CartItem');
    }

    public function status()
    {
    	return $this->hasMany('App\Models\CartItem')->where('status','!=','Pending');
    }
    
    public function completed()
    {
    	return $this->hasMany('App\Models\CartItem')->where('status','Receive')->orWhere('status','Decline');
    }

    public function request()
    {
        return $this->hasOne('App\Models\Requisition');
    }
}
