<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerts extends Model
{
    use HasFactory;
    protected $table = "alerts";
    protected $fillable = [
        'title',
        'image',
        'description',
        'hyper_link',
        'posted_by'
        
    ];
}
