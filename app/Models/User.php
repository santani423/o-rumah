<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    /**
     * Disable guarded attributes
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    protected $appends = [
        'formatted_created_at',
        'joined_at',
        'average_price',
        'total_sold',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function adsWishlists()
    {
        return $this->belongsToMany(Ads::class, 'wishlists', 'user_id', 'ads_id');
    }

    public function adsAuctions()
    {
        return $this->belongsToMany(Ads::class, 'auctions', 'user_id', 'ads_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function ads()
    {
        return $this->hasMany(Ads::class, 'user_id', 'id');
    }

    public function searchHistory()
    {
        return $this->hasMany(UserSearchHistory::class, 'user_id', 'id');
    }

    public function adsClickHistory()
    {
        return $this->hasMany(UserClickAdsHistory::class, 'user_id', 'id');
    }

    public function kpr()
    {
        return $this->hasMany(Kpr::class, 'user_id', 'id');
    }

    public function getJoinedAtAttribute()
    {
        return 'Bergabung sejak ' . $this->created_at->isoFormat('MMMM Y');
    }

    public function getAveragePriceAttribute()
    {
        $listAds = $this->ads;
        $total = 0;

        if ($total == 0) {
            return formatToRupiah($total);
        }

        foreach ($listAds as $ads) {
            $total += $ads->property->price;
        }

        return formatToRupiah($total / $listAds->count());
    }

    public function getTotalSoldAttribute()
    {
        return 0;
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->isoFormat('dddd, D MMMM Y');
    }

    public function scopeAgent()
    {
        return $this
            ->with('ads.property')
            ->withCount('ads as total_ads')
            ->with('company')
            ->where('type', 'agent')
            ->where('is_active', true)
            ->where('is_blocked', false);
    }

    public function scopeLawHelper()
    {
        return $this
            ->with('ads.property')
            ->withCount('ads as total_ads')
            ->with('company')
            ->where('type', 'lbh')
            ->where('is_active', true)
            ->where('is_blocked', false);
    }

    public function scopeNotaris()
    {
        return $this
            ->with('ads.property')
            ->withCount('ads as total_ads')
            ->with('company')
            ->where('type', 'notaris')
            ->where('is_active', true)
            ->where('is_blocked', false);
    }

    public function scopeLatest()
    {
        return $this->orderBy('created_at', 'desc');
    }

    public function propertyStatistics()
    {
        return $this->hasOne(UserPropertyStatistics::class);
    }
}
