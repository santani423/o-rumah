<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\AdBalance;
use App\Models\AdvertisingPoints;
use App\Models\AdvertisingalanceHistories;
use App\Models\AdBalaceControl;
use App\Models\UserClickAdsHistory;

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
}