<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HousingModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $appends = ['gallery', 'master_plan', 'basic_plan'];
    protected $hidden = ['media'];

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery')->map(function ($photo) {
            return $photo->original_url;
        });
    }

    public function getMasterPlanAttribute()
    {
        $master_plan = $this->getFirstMedia('master_plan');
        return [
            'original' => $master_plan->original_url,
            'thumb' => $master_plan->getUrl('thumb')
        ];
    }

    public function getBasicPlanAttribute()
    {
        $basic_plan = $this->getFirstMedia('basic_plan');
        return [
            'original' => $basic_plan->original_url,
            'thumb' => $basic_plan->getUrl('thumb')
        ];
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->performOnCollections('master_plan', 'basic_plan')
            ->width(800);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
