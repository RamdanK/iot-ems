<?php

namespace App\Livewire;

use App\Models\Device;
use Filament\Widgets\Widget;

class RelayStatus extends Widget
{
    public string|null $field = 'Relay';
    public string|null $deviceId = null;
    protected int | string | array $columnSpan = ['sm' => 1, 'md' => 2];
    protected static string $view = 'livewire.relay-status';

    public function getListeners()
    {
        return [
            "echo-private:device-status-updated.{$this->deviceId},DeviceStatusAccepted" => 'updateData',
        ];
    }

    public array $relays = [
        [
            'name' => 'Relay 1',
            'status' => 'OFF',
        ],
        [
            'name' => 'Relay 2',
            'status' => 'OFF',
        ],
        [
            'name' => 'Relay 3',
            'status' => 'OFF',
        ],
        [
            'name' => 'Relay 4',
            'status' => 'OFF',
        ]
    ];

    public function mount(): void
    {
        if ($this->deviceId) {
            $device = Device::where('id', $this->deviceId)->first();
            if ($device) {
                $metric = $device->metric();

                $this->relays = [
                    [
                        'name' => 'Relay 1',
                        'status' => $metric?->relay1 ? 'ON' : 'OFF',
                    ],
                    [
                        'name' => 'Relay 2',
                        'status' => $metric?->relay2 ? 'ON' : 'OFF',
                    ],
                    [
                        'name' => 'Relay 3',
                        'status' => $metric?->relay3 ? 'ON' : 'OFF',
                    ],
                    [
                        'name' => 'Relay 4',
                        'status' => $metric?->relay4 ? 'ON' : 'OFF',
                    ]
                ];
            }
        }
    }

    public function updateData($event)
    {
        $relay1 = $event['deviceStatus']['relay1'];
        $relay2 = $event['deviceStatus']['relay2'];
        $relay3 = $event['deviceStatus']['relay3'];
        $relay4 = $event['deviceStatus']['relay4'];

        $this->relays = [
            [
                'name' => 'Relay 1',
                'status' => $relay1 ? 'ON' : 'OFF',
            ],
            [
                'name' => 'Relay 2',
                'status' => $relay2 ? 'ON' : 'OFF',
            ],
            [
                'name' => 'Relay 3',
                'status' => $relay3 ? 'ON' : 'OFF',
            ],
            [
                'name' => 'Relay 4',
                'status' => $relay4 ? 'ON' : 'OFF',
            ]
        ];
    }
}
