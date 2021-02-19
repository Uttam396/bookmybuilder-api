<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentImages extends Model
{
    use HasFactory;
    protected $table = "document_images";
    protected $fillable = [
        'document_id',
        'documents_url'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
