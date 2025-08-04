<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    //
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'id_number',
        'nssf_number',
        'payroll_number',
        'salary',
        'phone_number',
        'date_of_joining',
        'notes', // We forgot this one earlier, good to add it now.
    ];
}
