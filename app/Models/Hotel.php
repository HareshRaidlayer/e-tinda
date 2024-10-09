<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name','image','city','state','country','added_by','is_approved','address','description','category_id'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
