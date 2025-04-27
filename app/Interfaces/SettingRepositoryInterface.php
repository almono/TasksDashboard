<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface SettingRepositoryInterface
{
    public function getApplicationSettings() : ?Collection;
}
