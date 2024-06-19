<?php

namespace App\Models;

use App\QueryBuilders\AdsQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class Ads extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $guarded = [];

    protected $appends = [
        'published_at_localized',
        'created_at_localized',
        'updated_at_localized',
        'deleted_at_localized',
        'is_user_already_bid_auction',
    ];

    public function newEloquentBuilder($query): AdsQueryBuilder
    {
        return new AdsQueryBuilder($query);
    }

    public function userWishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'ads_id', 'user_id');
    }

    public function userAuctions()
    {
        return $this->belongsToMany(User::class, 'auctions', 'ads_id', 'user_id')->withPivot('id', 'performed_at');
    }

    public function featured()
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function property()
    {
        return $this->hasOne(AdsProperty::class, 'ads_id', 'id');
    }

    public function ofood()
    {
        return $this->hasOne(Food::class, 'ads_id', 'id');
    }

    public function omerchant()
    {
        return $this->hasOne(Merchant::class, 'ads_id', 'id');
    }

    public function kpr()
    {
        return $this->hasMany(Kpr::class, 'ads_id', 'id');
    }

    public function adsClickHistory()
    {
        return $this->hasMany(UserClickAdsHistory::class, 'ads_id', 'id');
    }

    public function getIsUserAlreadyBidAuctionAttribute()
    {
        return $this->userAuctions()->where('user_id', auth()->id())->exists();
    }

    public function getPublishedAtLocalizedAttribute()
    {
        $timezone = getTimezoneFromSession();

        return $this->published_at?->setTimezone($timezone)->format('Y-m-d H:i:s');
    }

    public function getCreatedAtLocalizedAttribute()
    {
        $timezone = getTimezoneFromSession();

        return $this->created_at?->setTimezone($timezone)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtLocalizedAttribute()
    {
        $timezone = getTimezoneFromSession();

        return $this->updated_at?->setTimezone($timezone)->format('Y-m-d H:i:s');
    }

    public function getDeletedAtLocalizedAttribute()
    {
        $timezone = getTimezoneFromSession();

        return $this->deleted_at?->setTimezone($timezone)->format('Y-m-d H:i:s');
    }

    public function scopeLatest()
    {
        return $this->orderBy('created_at', 'desc');
    }

    public function scopeActive()
    {
        return $this->where('is_active', 1)
            ->where('is_archived', 0)
            ->whereNull('deleted_at');
    }

    public function scopeArchived()
    {
        return $this->where('is_active', 0)
            ->where('is_archived', 1)
            ->whereNotNull('deleted_at');
    }
}
