<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supply extends Model
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

    	if ($request->search_qualification) {
    		$query = $query->where('qualification_id', 'LIKE' ,'%'.$request->search_qualification .'%');
    	}

    	return $query;
    }

    public function qualification()
    {
        return $this->belongsTo('App\Models\Qualification');
    }
}
