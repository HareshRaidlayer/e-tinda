<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $table = 'donations';
    protected $fillable = [
        'church_id',
        'amount',
        'payment_option',
        'user_id',
        'status',
        'is_donatated'
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
