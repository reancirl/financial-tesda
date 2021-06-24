<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
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

    public function request()
    {
        return $this->belongsTo('App\Models\Requisition','requisition_id','id');
    }

    public function items()
    {
    	return $this->hasMany('App\Models\PurchaseRequestItem');
    }

    public function completed()
    {
    	return $this->hasMany('App\Models\PurchaseRequestItem')->where('status','Receive')->orWhere('status','Decline');;
    }

    public function status()
    {
    	return $this->hasMany('App\Models\PurchaseRequestItem')->where('status','!=','Pending');
    }

    public function getNumberAttribute(){
        if($this->fund_cluster) {
            return $this->fund_cluster . '-' . $this->created_at->year . '-' . str_pad($this->created_at->month,2,0, STR_PAD_LEFT) . '-' . str_pad($this->id,3,0, STR_PAD_LEFT);
        } else {
            return null;
        }
    }

    public function getPoNumberAttribute(){
        if($this->fund_cluster) {
            return $this->fund_cluster . '-' . $this->created_at->year . '-' . str_pad($this->created_at->month,2,0, STR_PAD_LEFT) . '-';
        } else {
            return null;
        }
    }
}
