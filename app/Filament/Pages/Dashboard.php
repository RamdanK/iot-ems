<?php

namespace App\Filament\Pages;

use Filament\Widgets;

use App\Filament\Widgets\DeviceBatteryTrendChart;
use App\Filament\Widgets\DeviceCurrentTrendChart;
use App\Filament\Widgets\DeviceEnergyTrendChart;
use App\Filament\Widgets\DeviceFrequencyTrendChart;
use App\Filament\Widgets\DevicePfTrendChart;
use App\Filament\Widgets\DevicePowerTrendChart;
use App\Filament\Widgets\DeviceTempTrendChart;
use App\Filament\Widgets\DeviceVoltageTrendChart;
use App\Models\Device;

class Dashboard extends \Filament\Pages\Dashboard
{

    public function getWidgetData(): array
    {
        $device = Device::where('uid', '7d06cfe7-5eaf-4151-8b86-ce97b08896b2')->first();

        return [
            'deviceId' => $device->id,
        ];
    }

    public function getWidgets(): array
    {
        return [
            DeviceVoltageTrendChart::class,
            DeviceCurrentTrendChart::class,
            DevicePowerTrendChart::class,
            DeviceEnergyTrendChart::class,
            DeviceFrequencyTrendChart::class,
            DevicePfTrendChart::class,
            DeviceTempTrendChart::class,
            DeviceBatteryTrendChart::class,
        ];
    }
}
