<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SupportMessage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $with = ['senderable'];
    protected $appends = ['attachments'];
    protected $hidden = ['media', 'senderable_id', 'senderable_type'];

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments')->map(function($image){
            return [
                'original' => $image->original_url,
                'thumb' => $image->getUrl('thumb')
            ];
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200);
    }

    public function support_conversation(){
        return $this->belongsTo(SupportConversation::class);
    }

    public function senderable(){
        return $this->morphTo();
    }
}
