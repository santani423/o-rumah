<?php

namespace App\QueryBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    /**
     * Get all the agents with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param array $filters The filters to apply
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllAgents(int $paginate = 1, array $filters = [])
    {
        $agentLists = User::query()
            ->with(['company'])
            ->agent()
            ->when(count($filters) > 0, function ($query) use ($filters) {
                if (array_key_exists('query', $filters) && $filters['query']) {
                    $query->where('name', 'like', $filters['query'] . '%');
                }
            })
            ->paginate($paginate)
            ->withQueryString();

        $agentLists->getCollection()->transform(
            function ($agent) {
                $data = [
                    ...mapAgent($agent)
                ];

                return $data;
            }
        );


        return $agentLists;
    }

    /**
     * Get all the notaris with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param array $filters The filters to apply
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllNotaris(int $paginate = 1, array $filters = [])
    {
        $lawHelper = User::query()
            ->with(['company'])
            ->notaris()
            ->when(count($filters) > 0, function ($query) use ($filters) {
                if (array_key_exists('query', $filters) && $filters['query']) {
                    $query->where('name', 'like', $filters['query'] . '%');
                }
            })
            ->paginate($paginate)
            ->withQueryString();

        $lawHelper->getCollection()->transform(
            function ($lawHelper) {
                $data = [
                    ...mapAgent($lawHelper)
                ];

                return $data;
            }
        );


        return $lawHelper;
    }

    /**
     * Get all the law helper with optional pagination and sorting.
     *
     * @param int $paginate The number of items per page
     * @param array $filters The filters to apply
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllLawHelper(int $paginate = 1, array $filters = [])
    {
        $lawHelper = User::query()
            ->with(['company'])
            ->lawHelper()
            ->when(count($filters) > 0, function ($query) use ($filters) {
                if (array_key_exists('query', $filters) && $filters['query']) {
                    $query->where('name', 'like', $filters['query'] . '%');
                }
            })
            ->paginate($paginate)
            ->withQueryString();

        $lawHelper->getCollection()->transform(
            function ($lawHelper) {
                $data = [
                    ...mapAgent($lawHelper)
                ];

                return $data;
            }
        );


        return $lawHelper;
    }

    /**
     * Retrieve agents with their associated company.
     *
     * @param int $count Number of agents to retrieve
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of agents with associated company
     */
    public function getAgents(int $count = 8)
    {
        return User::query()
            ->with('company')
            ->agent()
            ->take($count)
            ->get()
            ->map(fn ($agent) => mapAgent($agent));
    }

    /**
     * Get user by username.
     *
     * @param string $username
     * @param array $filters
     *
     * @return array|null
     */
    public function getByUsername(string $username, array $filters = [])
    {
        $agent = User::query()
            ->with(['company'])
            ->withCount('ads as total_ads')
            ->where('username', $username)
            ->first();

        if (!$agent) {
            return null;
        }

        $agent = [
            ...mapAgent($agent),
            'ads' => $agent
                ->ads()
                ->when(count($filters) > 0, function ($query) use ($filters) {
                    $query->whereHas('property', function ($q) use ($filters) {
                        if (array_key_exists('query', $filters) && $filters['query']) {
                            $q
                                ->where('title', 'like', $filters['query'] . '%')
                                ->orWhere('area', 'like', $filters['query'] . '%')
                                ->orWhere('address', 'like', $filters['query'] . '%');
                        }
                    });
                })
                ->when(!array_key_exists('sort', $filters), function ($query) {
                    $query->orderBy('id', 'asc');
                })
                ->when(array_key_exists('sort', $filters), function ($query) use ($filters) {
                    switch ($filters['sort']) {
                        case 1:
                            $query->latest();
                            break;
                        default:
                            $query->orderBy('id', 'asc');
                            break;
                    }
                })
                ->paginate(9)
        ];

        $agent['ads']->getCollection()->transform(
            function ($ads) {
                return [
                    ...mapAds($ads)
                ];
            }
        );

        return $agent;
    }

    /**
     * Add the specified ad to the user's list of favorited ads.
     *
     * @param int $adsId The ID of the ad to be added to favorites
     */
    public
    function addFavoritedAds(int $adsId)
    {
        $user = auth()->user();

        $user->adsWishlists()->toggle($adsId);
    }

    /**
     * Removes the favorited ads for the user.
     *
     * @param array $adsIds The array of ad IDs to be removed from the user's favorites.
     */
    public
    function removeFavoritedAds(array $adsIds)
    {
        $user = auth()->user();

        $user->adsWishlists()->detach($adsIds);
    }
}
