<?php

namespace App\QueryBuilders;

use App\Models\Ads;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AdsQueryBuilder extends Builder
{
    /**
     * Retrieve the latest properties.
     *
     * @param int $count the number of properties to retrieve
     * @return \Illuminate\Support\Collection the latest properties
     */
    public function getLatestProperty(int $count = 10)
    {
        return Ads::query()
            ->with(['featured', 'property'])
            ->active()
            ->latest()
            ->take($count)
            ->get()
            ->map(fn ($ads) => mapAds($ads));
    }

    /**
     * Get all the ads with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param bool $loadAgent Whether to load the agent
     * @param string|array|null $adsPropertyType The type of ads property
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllAds(
        int               $paginate = 10,
        bool              $loadAgent = true,
        string|array|null $adsPropertyType = null,
        array             $filters = [],
    ) {
        $adsLists = Ads::query()
            ->join('ads_properties', 'ads.id', '=', 'ads_properties.ads_id')
            ->when($adsPropertyType, function ($query) {
                $query->join('auctions', 'ads_properties.ads_id', '=', 'auctions.ads_id', 'right')
                    ->join('users', 'auctions.user_id', '=', 'users.id');
            })
            ->select(
                'ads.id',
                'ads.title',
                'ads.slug',
                'ads.description',
                'ads.type',
                'ads.published_at',
                'ads.points',
                'ads.user_id',
                'ads.is_active',
                'ads.is_archived',
                'ads.status',
                'ads.history',
                'ads.deleted_at',
                'ads.created_at',
                'ads.updated_at',
                'ads_properties.price',
                'ads_properties.lt',
                'ads_properties.lb',
            )
            ->when($adsPropertyType, function ($query) {
                $query->addSelect('users.id as user_id', 'users.username as username');
            })
            ->with([
                'featured',
                'property',
            ])
            ->where('ads.is_active', 1)
            ->where('ads.is_archived', 0)
            ->whereNull('ads.deleted_at')
            ->when(!array_key_exists('sort', $filters), function ($query) {
                $query->latest();
            })
            ->when(array_key_exists('sort', $filters), function ($query) use ($filters) {
                switch ($filters['sort']) {
                    case 1:
                        $query->latest();
                        break;
                    case 2:
                        $query->orderBy('ads_properties.price', 'asc');
                        break;
                    case 3:
                        $query->orderBy('ads_properties.price', 'desc');
                        break;
                    case 4:
                        $query->orderBy('ads_properties.lt', 'asc');
                        break;
                    case 5:
                        $query->orderBy('ads_properties.lt', 'desc');
                        break;
                    case 6:
                        $query->orderBy('ads_properties.lb', 'asc');
                        break;
                    case 7:
                        $query->orderBy('ads_properties.lb', 'desc');
                        break;
                    default:
                        $query->latest();
                        break;
                }
            })
            ->when($adsPropertyType, function ($query) use ($adsPropertyType) {
                $query->whereHas('property', function ($query) use ($adsPropertyType) {
                    if (is_array($adsPropertyType)) {
                        $query->whereIn('ads_type', $adsPropertyType);
                    } else {
                        $query->where('ads_type', $adsPropertyType);
                    }
                });
            })
            ->when(count($filters) > 0, function ($query) use ($filters) {
                $query->whereHas('property', function ($q) use ($filters) {

                    if (array_key_exists('ads_type', $filters) && $filters['ads_type']) {
                        $q->where('ads_type', $filters['ads_type']);
                    }

                    if (array_key_exists('property_type', $filters) && $filters['property_type']) {
                        $q->where('property_type', $filters['property_type']);
                    }

                    if (array_key_exists('min_price', $filters) && array_key_exists('max_price', $filters)) {
                        if (($filters['min_price'] && $filters['max_price'])) {
                            $q->whereBetween('price', [$filters['min_price'], $filters['max_price']]);
                        } elseif ($filters['min_price']) {
                            $q->where('price', '>=', $filters['min_price']);
                        } elseif ($filters['max_price']) {
                            $q->where('price', '<=', $filters['max_price']);
                        }
                    }

                    if (array_key_exists('min_lt', $filters) && array_key_exists('max_lt', $filters)) {
                        if (($filters['min_lt'] && $filters['max_lt'])) {
                            $q->whereBetween('lt', [$filters['min_lt'], $filters['max_lt']]);
                        } elseif ($filters['min_lt']) {
                            $q->where('lt', '>=', $filters['min_lt']);
                        } elseif ($filters['max_lt']) {
                            $q->where('lt', '<=', $filters['max_lt']);
                        }
                    }

                    if (array_key_exists('min_lb', $filters) && array_key_exists('max_lb', $filters)) {
                        if (($filters['min_lb'] && $filters['max_lb'])) {
                            $q->whereBetween('lb', [$filters['min_lb'], $filters['max_lb']]);
                        } elseif ($filters['min_lb']) {
                            $q->where('lb', '>=', $filters['min_lb']);
                        } elseif ($filters['max_lb']) {
                            $q->where('lb', '<=', $filters['max_lb']);
                        }
                    }

                    if (array_key_exists('query', $filters) && $filters['query']) {
                        $q
                            ->where('title', 'like', $filters['query'] . '%')
                            ->orWhere('area', 'like', $filters['query'] . '%')
                            ->orWhere('address', 'like', $filters['query'] . '%');
                    }
                });
            })
            ->paginate($paginate)
            ->withQueryString();

        $adsLists->getCollection()->transform(
            function ($ads) use ($loadAgent) {
                $data = [
                    ...mapAds($ads),
                ];

                if ($loadAgent) {
                    $data['agent'] = mapAgent($ads->user);
                }

                $data['property'] = $ads->property;

                if ($ads->user_id) {
                    $data['user_id'] = $ads->user_id;
                    $data['username'] = $ads->username;
                }

                return $data;
            }
        );

        return $adsLists;
    }

    /**
     * Get all the ofoods ads with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param array $filters The filters to apply
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllOFoodsAds(int $paginate = 10, array $filters = [])
    {
        $adsLists = Ads::query()
            ->with(['featured'])
            ->active()
            ->latest()
            ->where('type', '=', 'foods')
            ->when(count($filters) > 0, function ($query) use ($filters) {
                $query->where('title', 'like', $filters['query'] . '%')
                    ->orWhereHas('ofood', function ($q) use ($filters) {
                        $q->where('address', 'like', $filters['query'] . '%');
                    });
            })
            ->paginate($paginate)
            ->withQueryString();

        $adsLists->getCollection()->transform(
            function ($ads) {
                $data = [
                    ...mapAds($ads),
                    'address' => $ads->ofood?->address,
                ];

                return $data;
            }
        );


        return $adsLists;
    }

    /**
     * Get all the merchant ads with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param array $filters The filters to apply
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllOMerchantAds(int $paginate = 10, array $filters = [])
    {
        $adsLists = Ads::query()
            ->with(['featured'])
            ->active()
            ->latest()
            ->where('type', '=', 'merchant')
            ->when(count($filters) > 0, function ($query) use ($filters) {
                $query->where('title', 'like', $filters['query'] . '%')
                    ->orWhereHas('omerchant', function ($q) use ($filters) {
                        $q->where('address', 'like', $filters['query'] . '%');
                    });
            })
            ->paginate($paginate)
            ->withQueryString();

        $adsLists->getCollection()->transform(
            function ($ads) {
                $data = [
                    ...mapAds($ads),
                    'address' => $ads->omerchant?->address,
                ];

                return $data;
            }
        );


        return $adsLists;
    }

    /**
     * Retrieves an ad by its slug, including related data such as featured, property, media, and agent information.
     *
     * @param string $slug The slug of the ad to retrieve.
     * @param string $username The username of user if exists.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the ad with the given slug is not found.
     * @return array An array containing the ad data, including is_favorited_by_current_user, lat, lng, lt, agent, and media.
     */
    public function getAdsBySlug($slug, $username = null)
    {
        $ads = Ads::query()
            ->with(['featured', 'property', 'media', 'userAuctions'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        if ($username !== null) {
            $user = User::where('username', $username)->firstOrFail();
        }


        return [
            ...mapAds($ads),
            'is_favorited_by_current_user' => $this->isFavoritedByCurrentUser($ads->id),
            'lat' => (float)$ads->property?->lat,
            'lng' => (float)$ads->property?->lng,
            'lt' => $ads->property?->lt,
            'agent' => mapAgent($ads->user ?? $user),
            'media' => $ads->media->map(fn ($media) => [
                'order' => $media->order_column,
                'url' => $media->original_url,
            ])->toArray(),
        ];
    }

    /**
     * Get all the ads with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param bool $loadAgent Whether to load the agent
     * @param string|array|null $adsPropertyType The type of ads property
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFavoritedAds(
        int               $paginate = 10,
        bool              $loadAgent = true,
        string|array|null $adsPropertyType = null,
    ) {
        $adsLists = Ads::query()
            ->with(['featured', 'property'])
            ->active()
            ->latest()
            ->when($adsPropertyType, function ($query) use ($adsPropertyType) {
                $query->whereHas('property', function ($query) use ($adsPropertyType) {
                    if (is_array($adsPropertyType)) {
                        $query->whereIn('ads_type', $adsPropertyType);
                    } else {
                        $query->where('ads_type', $adsPropertyType);
                    }
                });
            })
            ->whereHas('userWishlists', fn ($query) => $query->where('user_id', auth()->id()))
            ->paginate($paginate)
            ->withQueryString();

        $adsLists->getCollection()->transform(
            function ($ads) use ($loadAgent) {
                $data = [
                    ...mapAds($ads),
                ];

                if ($loadAgent) {
                    $data['agent'] = mapAgent($ads->user);
                }

                return $data;
            }
        );


        return $adsLists;
    }

    /**
     * Check if the given ad is favorited by the current user.
     *
     * @param int $adsId The ID of the ad to check for favorited status
     * @return bool
     */
    public function isFavoritedByCurrentUser(int $adsId)
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();

        return $user->adsWishlists->contains($adsId);
    }
}
