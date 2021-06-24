<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qualification extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function scopeSearch($query, $request)
    {
    	if ($request->search_code) {
    		$query = $query->where('code', 'LIKE' ,'%'.$request->search_code .'%');
    	}

    	if ($request->search_name) {
    		$query = $query->where('name', 'LIKE' ,'%'.$request->search_name .'%');
    	}

    	return $query;
    }

	public function user()
    {
        return $this->hasMany('App\Models\User');
    }

    public function closed_po()
    {
        return $this->hasMany('App\Models\PurchaseOrder')->where('is_active',0);
    }

    public function purchase_requests()
    {
        return $this->hasMany('App\Models\PurchaseRequest');
    }
}
