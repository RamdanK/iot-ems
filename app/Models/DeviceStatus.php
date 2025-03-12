<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceStatus extends Model
{
    protected $fillable = [
        'device_id',
        'date',
        'time',
        'voltage1',
        'current1',
        'power1',
        'energy1',
        'freq1',
        'pf1',
        'voltage2',
        'current2',
        'power2',
        'energy2',
        'freq2',
        'pf2',
        'temp',
        'battery',
        'relay1',
        'relay2',
        'relay3',
        'relay4',
    ];

    protected function casts(): array
    {
        return [
            'voltage1' => 'decimal:2',
            'current1' => 'decimal:2',
            'power1' => 'decimal:2',
            'energy1' => 'decimal:2',
            'freq1' => 'decimal:2',
            'pf1' => 'decimal:2',
            'voltage2' => 'decimal:2',
            'current2' => 'decimal:2',
            'power2' => 'decimal:2',
            'energy2' => 'decimal:2',
            'freq2' => 'decimal:2',
            'pf2' => 'decimal:2',
            'temp' => 'decimal:2',
            'battery' => 'decimal:2',
            'relay1' => 'boolean',
            'relay2' => 'boolean',
            'relay3' => 'boolean',
            'relay4' => 'boolean',
        ];
    }
}
