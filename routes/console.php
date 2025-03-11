<?php

use App\Console\Commands\SendDummyDeviceStatusCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SendDummyDeviceStatusCommand::class, ['uid' => '7d06cfe7-5eaf-4151-8b86-ce97b08896b2'])->everyFiveSeconds();
