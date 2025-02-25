<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $with = ['service_translations'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $service_translation = $this->service_translations->where('lang', $lang)->first();
        return $service_translation != null ? $service_translation->$field : $this->$field;
    }

    public function service_translations()
    {
        return $this->hasMany(ServiceTranslation::class);
    }




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
