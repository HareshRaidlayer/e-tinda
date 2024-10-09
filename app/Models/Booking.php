<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'hotel_booking';
    protected $fillable = [
        'hotel_id', 'room_id','user_id','owner_id', 'number_of_rooms','total_price', 'number_of_guests',
        'check_in_date', 'check_out_date', 'full_name', 'email', 'phone'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
