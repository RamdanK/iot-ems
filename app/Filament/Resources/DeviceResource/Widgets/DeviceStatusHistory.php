<?php

namespace App\Filament\Resources\DeviceResource\Widgets;

use App\Models\DeviceStatus;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class DeviceStatusHistory extends BaseWidget
{
    public $deviceId;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                DeviceStatus::query()->where('device_id', $this->deviceId)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Date')->date('d-m-Y')->sortable(),
                Tables\Columns\TextColumn::make('time')->label('Time')->time()->sortable(),
                Tables\Columns\TextColumn::make('voltage1')->label('Voltage 1 (V)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('current1')->label('Current 1 (A)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('power1')->label('Power 1 (W)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('energy1')->label('Energy 1 (J)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('freq1')->label('Freq 1 (Hz)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('pf1')->label('PF 1 (kW)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('voltage2')->label('Voltage 2 (V)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('current2')->label('Current 2 (A)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('power2')->label('Power 2 (W)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('energy2')->label('Energy 2 (J)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('freq2')->label('Freq 2 (Hz)')->alignRight()->sortable(),
                Tables\Columns\TextColumn::make('pf2')->label('PF 2 (kW)')->alignRight()->sortable(),
            ])
            ->filters([
                DateRangeFilter::make('created_at')->label('Date'),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('300s');
    }
}
