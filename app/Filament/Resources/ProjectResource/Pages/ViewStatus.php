<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\DeviceResource;
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
use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\Concerns;

class ViewStatus extends Page
{
    use Concerns\HasRelationManagers;
    use Concerns\InteractsWithRecord {
        configureAction as configureActionRecord;
    }
    use InteractsWithFormActions;

    protected static string $view = 'pages.devices.view-status';

    protected static string $resource = DeviceResource::class;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();
    }

    protected function authorizeAccess(): void
    {
        abort_unless(static::getResource()::canView($this->getRecord()), 403);
    }
    protected function hasInfolist(): bool
    {
        return (bool) count($this->getInfolist('infolist')->getComponents());
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return static::getResource()::infolist($infolist);
    }

    public function getTitle(): string|Htmlable
    {
        return 'Device Status: ' . $this->record->name . ' (' . $this->record->project->name . ')';
    }

    public function getWidgetData(): array
    {
        return [
            'deviceId' => $this->record->id,
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_status')
                ->label('History')
                ->icon('heroicon-o-table-cells')
                ->url(fn(Device $record) => DeviceResource::getUrl('history', ['record' => $record->uid])),
        ];
    }

    protected function getHeaderWidgets(): array
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
