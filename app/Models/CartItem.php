<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    public $guarded = [];

    public function scopeExist($query, $supply_id, $cart_id)
    {
    	return $query->where('supply_id',$supply_id)->where('cart_id',$cart_id);
    }

    public function supply()
    {
        return $this->belongsTo('App\Models\Supply');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','updated_by','id');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
