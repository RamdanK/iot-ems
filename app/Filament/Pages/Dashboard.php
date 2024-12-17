<?php

namespace App\Filament\Pages;

use Filament\Widgets;

class Dashboard extends \Filament\Pages\Dashboard
{

    public function getWidgets(): array
    {
        return [
            Widgets\AccountWidget::class,
            Widgets\FilamentInfoWidget::class,
        ];
    }
}
