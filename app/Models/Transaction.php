<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    
use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'user_id', // This is the ID of the user who made the transaction
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
