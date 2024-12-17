<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use App\Filament\Resources\DeviceResource\Widgets\DeviceStatusHistory;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewStatusDetail extends ViewRecord
{
    protected static string $resource = DeviceResource::class;

    protected static string $view = 'filament.resources.device-resource.pages.view-status-detail';

    public function getTitle(): string|Htmlable
    {
        return 'Device Status History: ' . $this->record->name . ' (' . $this->record->project->name . ')';
    }

    public function getHeaderWidgetsColumns(): array|int|string
    {
        return 1;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DeviceStatusHistory::class,
        ];
    }

    public function getWidgetData(): array
    {
        return [
            'deviceId' => $this->record->id
        ];
    }
}
