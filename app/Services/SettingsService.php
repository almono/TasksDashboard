<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\SettingRepository;
use Illuminate\Support\Collection;

class SettingsService
{
    public function __construct(
        private SettingRepository $settingRepository
    ) {}

    public function getApplicationSettings() : ?Collection
    {
        return $this->settingRepository->getApplicationSettings();
    }
}