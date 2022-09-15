<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Subdivision extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $appends = ['gallery'];
    protected $hidden = ['media'];

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery')->map(function($image){
            return [
                'original' => $image->original_url,
                'thumb' => $image->getUrl('thumb')
            ];
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(800);
    }
}
