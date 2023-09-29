<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * <int, string>
     */
    protected $fillable = [
        'user_id',
        'token',
        'amount',
        'payment_id',
    ];
}
