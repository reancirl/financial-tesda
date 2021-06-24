<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];

    public function scopeSearch($query, $request)
    {
    	if ($request->search_status) {
    		$query = $query->where('status', 'LIKE' ,'%'.$request->search_name .'%');
    	}

    	return $query;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}
