<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = "staffs";
    protected $fillable = [
        'uid',
        'profile_picture',
        'name',
        'phone',
        'email',
        'user_type',
        'password',
        'confirm_password',
        'documents',
        'remarks',
        'status'
    ];
}
