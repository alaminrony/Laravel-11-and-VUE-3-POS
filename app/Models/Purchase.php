<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['total_amount'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function purchaseDetails(){
        return $this->hasMany(PurchaseItem::class);
    }
}
