<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery')->map(function ($photo) {
            return $photo->original_url;
        });
    }
}
