<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharchBranch extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'charch_branch';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'name',
        'bank_account_number',
        'bank_ifsc',
        'bank_routing_number',
        'stripe_account_id',
        'stripe_bank_account_id',
        'bank_name',
        'email',
        'razorpay_contact_id',
        'razorpay_fund_account_id',
        'phone_number',
        'address',
        'country',
        'added_by',
        'status',
    ];
}
