<?php

namespace App\Console\Commands;

use App\Events\DeviceStatusAccepted;
use App\Models\Device;
use Illuminate\Console\Command;

class SendDummyDeviceStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-dummy-device-status-command {uid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dummy data for sending device status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uid = $this->ask('What is your device UID to begin seeding data dummy?');
        $device = Device::where('uid', $uid)->first();

        if ($device) {
            $status = $device->statuses()->create([
                'date' => now(),
                'time' => now(),
                'voltage1' => fake()->randomFloat(2, 6, 12),
                'current1' => fake()->randomFloat(2, 1, 4),
                'power1' => fake()->randomFloat(2, 110, 220),
                'energy1' => fake()->randomFloat(2, 20, 40),
                'freq1' => fake()->randomFloat(2, 60, 120),
                'pf1' => fake()->randomFloat(2, 1, 10),
                'voltage2' => fake()->randomFloat(2, 6, 12),
                'current2' => fake()->randomFloat(2, 1, 4),
                'power2' => fake()->randomFloat(2, 110, 220),
                'energy2' => fake()->randomFloat(2, 20, 40),
                'freq2' => fake()->randomFloat(2, 60, 120),
                'pf2' => fake()->randomFloat(2, 1, 10),
                'temp' => fake()->randomFloat(2, 30, 80),
                'battery' => fake()->randomFloat(2, 10, 100),
            ]);

            DeviceStatusAccepted::dispatch($status);
        }
    }
}
