<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Resources\DeviceResource;
use App\Filament\Resources\ProjectResource;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

class DevicesRelationManager extends RelationManager
{
    protected static string $relationship = 'devices';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uid')
                    ->label('Device UID')
                    ->required()
                    ->unique('devices', 'uid', ignoreRecord: true)
                    ->maxLength(255),
                    Forms\Components\Select::make('type')
                    ->options([
                        'esp32' => 'ESP32',
                        'relay' => 'Relay',
                        'server' => 'Server',
                        'switch' => 'Switch',
                        'router' => 'Router',
                        'firewall' => 'Firewall',
                        'ups' => 'UPS',
                        'printer' => 'Printer',
                        'storage' => 'Storage',
                        'camera' => 'Camera',
                        'other' => 'Other',
                    ])
                    ->label('Device Type')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Device Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('uid')->copyable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Device')
                    ->modalHeading('Add Device'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_status')
                    ->label('Monitoring')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->url(fn (Device $record) => DeviceResource::getUrl('status', ['record' => $record->uid])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
