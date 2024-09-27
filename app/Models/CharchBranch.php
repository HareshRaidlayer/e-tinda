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
        'email',
        'phone_number',
        'address',
        'country',
        'added_by',
        'status',
    ];
}
