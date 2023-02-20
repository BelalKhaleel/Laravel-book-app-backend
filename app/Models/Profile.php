<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'about',
        'social_media_link',
      
    ];

    public function author(){
        return $this->belongsTo(Author::class);
    }
}
