<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DeviceBatteryTrendChart;
use App\Filament\Widgets\DeviceCurrentTrendChart;
use App\Filament\Widgets\DeviceEnergyTrendChart;
use App\Filament\Widgets\DeviceFrequencyTrendChart;
use App\Filament\Widgets\DevicePfTrendChart;
use App\Filament\Widgets\DevicePowerTrendChart;
use App\Filament\Widgets\DeviceTempTrendChart;
use App\Filament\Widgets\DeviceVoltageTrendChart;
use App\Livewire\RelayStatus;
use App\Models\Device;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function mount(): void
    {
        $this->device = Device::query()->with(['project'])->inRandomOrder()->first();
    }

    protected Device|null $device = null;

    public function getTitle(): string|Htmlable
    {
        $deviceName = $this->device ? ' - Device: '.$this->device->name : '';
        $title = static::$title ?? __('filament-panels::pages/dashboard.title');
        return $title.$deviceName.' ('.$this->device?->project?->name.')';
    }

    public function getWidgetData(): array
    {
        return [
            'deviceId' => $this->device?->id,
        ];
    }

    public function getWidgets(): array
    {
        return [
            RelayStatus::class,
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
