<?php
namespace App\Services;

use App\Models\DeviceStatus;
use Illuminate\Database\Eloquent\Collection;

class DeviceMatrixService
{
    public static function getDeviceTrend($deviceId, array $column = ['*'], $start = null, $end = null): Collection
    {
        $startDate = $start ?? now()->startOfDay();
        $endDate = $end ?? now()->endOfDay();
        $data = DeviceStatus::query()
            ->select($column)
            ->where('device_id', $deviceId)
            ->whereBetween('created_at', [$startDate, $endDate])->get();

        return $data;
    }

    public static function getDeviceVoltageTrend($deviceId, $start = null, $end = null): array
    {
        $data = DeviceStatus::query()->select('created_at as date', 'voltage1 as value')->whereBetween('date', [$start ?? now()->startOfDay(), $end ?? now()->endOfDay()])->get();

        return [
            'data' => $data->map(fn(DeviceStatus $value) => (float) $value->value)->toArray(),
            'labels' => $data->map(fn(DeviceStatus $value) => $value->date)->toArray(),
        ];
    }
}
