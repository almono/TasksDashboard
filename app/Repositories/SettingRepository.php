<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    public function getApplicationSettings() : ?Collection
    {
        return Setting::all()->pluck('value', 'name');
    }
}