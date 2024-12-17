<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceResource\Pages;
use App\Filament\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uid')
                    ->label('Device UID')
                    ->required()
                    ->unique('devices', 'uid', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->label('Device Type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label('Device Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('view_status')
                    ->label('Monitoring')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->url(fn(Device $record) => DeviceResource::getUrl('status', ['record' => $record->uid])),
                Tables\Actions\Action::make('view_status')
                    ->label('History')
                    ->icon('heroicon-o-table-cells')
                    ->url(fn(Device $record) => DeviceResource::getUrl('history', ['record' => $record->uid])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
            'status' => Pages\ViewStatus::route('/{record}/status'),
            'history' => Pages\ViewStatusDetail::route('/{record}/history'),
        ];
    }
}
