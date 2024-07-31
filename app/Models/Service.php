<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    public function thumbnail()
    {
        return $this->belongsTo(Upload::class, 'thumbnail_img');
    }

    public function carts()
    {
        return $this->hasMany(ServiceCart::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class ,'user_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
