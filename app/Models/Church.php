<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $table = 'churches';

    protected $fillable = [
        'name','thumbnail_img' ,'address', 'email', 'stripe_account_id', 'bank_account_number', 'bank_routing_number', 'bank_name'
    ];

}
