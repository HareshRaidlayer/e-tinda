<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCart extends Model
{
    protected $table= 'service_carts';
    protected $guarded = [];
    protected $fillable = ['address_id','tax','shipping_cost','discount','product_referral_code','coupon_code','coupon_applied','quantity','user_id','temp_user_id','owner_id','product_id','variation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Service::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
