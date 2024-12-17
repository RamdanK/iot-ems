<?php

namespace App;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum DeviceStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case Online = 'Online';
    case Offline = 'Offline';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Offline => 'Offline',
            self::Online => 'Online',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Offline => 'danger',
            self::Online => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Offline => 'heroicon-o-signal-slash',
            self::Online => 'heroicon-0-signal',
        };
    }
}
