<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\Ads;
use App\Models\ReferralCode;
use App\Models\UserClickAdsHistory;
use App\Models\UserPropertyStatistics;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            $poin->balance = 0;
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
    
    public function getOrCreateReferralCode(int $userId): ReferralCode
    {
        // Check if a referral code already exists for the user
        $referralCode = ReferralCode::where('user_id', $userId)->first();

        if ($referralCode) {
            // Return existing referral code
            return $referralCode;
        }

        // Create a new referral code
        $newReferralCode = new ReferralCode();
        $newReferralCode->code = $this->generateUniqueCode();
        $newReferralCode->user_id = $userId;
        $newReferralCode->expires_at = Carbon::now()->addDays(30); // Set an expiration date if needed
        $newReferralCode->status = 'active';
        $newReferralCode->usage_limit = 1; // Default usage limit
        $newReferralCode->times_used = 0;
        $newReferralCode->save();

        return $newReferralCode;
    }

    /**
     * Generate a unique referral code.
     *
     * @return string
     */
    protected function generateUniqueCode(): string
    {
        do {
            $code = Str::random(8); // Generate an 8-character random code
        } while (ReferralCode::where('code', $code)->exists());

        return $code;
    }
}
