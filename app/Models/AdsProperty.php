<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class AdsProperty extends Model
{
    use HasFactory, HasSpatial;

    protected $guarded = [];

    protected $appends = [
        'formatted_price',
    ];

    protected $casts = [
        'location' => Point::class,
    ];

    public function ads()
    {
        return $this->belongsTo(Ads::class, 'ads_id', 'id');
    }

    public function getFormattedPriceAttribute()
    {
        $formattedPrice = formatToRupiah($this->price);

        if ($this->ads_type == 'Sewa') {
            $formattedPrice .= ' / ' . $this->rent_type;
        }

        return $formattedPrice;
    }

    public static function getAllPropertyType()
    {
        // $propertyType = PropertyType::pluck('name', 'name');
        return [
            'Apartemen',
            'Kantor',
            'Ruko',
            'Rumah',
            'Tanah'
        ];
        // return $propertyType;

        /* return $propertyType->mapWithKeys(function ($value, $key) {
            return [strtolower($key) => $value];
        })->toArray(); */
    }
    public static function getAllEnvironmentalConditions()
    {

        return [
            'Keamanan 24 Jam',
            'Akses Jalan Tol',
            'Dekat Kawasan Bisnis',
            'Dekat Sekolah',
            'Bebas Banjir',
            'Kids Playground',
            'Pusat Kebugaran',
            'Masuk Mobil',
            'Dekat Pusat Perbelanjaan',
            'Dekat Rumah Sakit',
            'Kolam Renang',
            'Jogging Track',
            'Dekat Jalan Raya',
            'Pusat Bisnis',
            'Dekat Stasiun',
            'Dekat Tempat Ibadah',
            'Taman',
        ];
    }

    public static function getAllCertificates()
    {
        return [
            'SHM',
            'HGB',
            'Hak Pakai',
            'HGU',
            'Hak Kelola',
            'AJB',
            'PPJB',
            'Strata Title',
            'Lainnya',
        ];
    }

    public static function getApartmenType()
    {
        return [
            'Apartemen Studio',
            'Apartemen Junior 1 Bedroom',
            'Apartemen 2 Bedroom',
            'Apartemen 3 Bedroom',
            'Apartemen Classic Six',
            'Apartemen Alcove',
            'Apartemen Convertible',
            'Apartemen Loft',
            'Apartemen Penthouse',
            'Apartemen Duplex',
            'Apartemen Triplex',
            'Apartemen Garden',
            'Apartemen Junior 4',
            'Apartemen Convertible Studio'
        ];
    }

    public static function getFurnishedCondition()
    {
        return [
            'Furnished',
            'Semi-Furnished',
            'Unfurnished',
        ];
    }

    public static function getAllHouseFacility()
    {
        return [
            'AC',
            'Kolam Renang',
            'TV Kabel',
            'Internet',
        ];
    }

    public static function getAllOtherFacility()
    {
        return [
            'Keamanan 24 Jam',
            'Akses Jalan Tol',
            'Dekat Kawasan Bisnis',
            'Dekat Sekolah',
            'Bebas Banjir',
            'Kids Playground',
            'Pusat Kebugaran',
            'Masuk Mobil',
            'Dekat Pusat Perbelanjaan',
            'Dekat Rumah Sakit',
            'Kolam Renang',
            'Jogging Track',
            'Dekat Jalan Raya',
            'Pusat Bisnis',
            'Dekat Stasiun',
            'Dekat Tempat Ibadah',
            'Taman',
        ];
    }
}
