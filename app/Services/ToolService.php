<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\Ads;
use App\Models\UserClickAdsHistory;
use App\Models\UserPropertyStatistics;

trait ToolService
{
    private function code($code, $count)
    {
        $prefix = date('Ymd'); // Format: YYYYMMDD for year, month, and day
        $suffix = strtoupper(substr(md5(uniqid()), 0, 8)); // Generate 8-character random hash

        // Combine prefix and suffix for unique code
        $uniqueCode = $prefix . $suffix;

        // Check for uniqueness (optional)


        // Increment count for next code
        $this->count++;

        return $uniqueCode;
    }

    public function ensureStatisticsExistForAllUsers($id)
    {
        // Check if the user already has a user_property_statistics record
        $userStatisticsExists = UserPropertyStatistics::where('user_id', $id)->exists();

        // Create a statistics record if none exists
        if (!$userStatisticsExists) {
            $userPropertyStatistics = new UserPropertyStatistics();
            $userPropertyStatistics->user_id = $id;
            $userPropertyStatistics->total_properties = 0; // Default value
            $userPropertyStatistics->sold_rented_properties = 0; // Default value
            $userPropertyStatistics->total_rented_properties = 0; // Default value
            $userPropertyStatistics->save();
        }
    }

    public function getOrCreateUserAdBalance($userId)
    {
        $poin = AdBalance::where('user_id', $userId)->first();

        if (!$poin) {
            $poin = new AdBalance();
            $poin->user_id = $userId;
            $poin->balance = 20;
            $poin->save();
        }

        return $poin;
    }

    public function getPropertyAdStatistics($userId)
    {
        // Query the ads table to get the required counts
        $totalProperties = Ads::where('user_id', $userId)
            ->where('type', 'property')
            ->count();

        $activeProperties = Ads::where('user_id', $userId)
            ->where('type', 'property')
            ->where('is_active', 1)
            ->count();

        $nonActiveProperties = Ads::where('user_id', $userId)
            ->where('type', 'property')
            ->where('is_active', 0)
            ->count();

        // Return the counts as an array
        return [
            'total_properties' => $totalProperties,
            'active_properties' => $activeProperties,
            'non_active_properties' => $nonActiveProperties,
        ];
    }
}
