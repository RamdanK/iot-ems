<?php

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('device-status-updated.{deviceId}', function (User $user, $deviceId) {
    $device = Device::with('owner')->find($deviceId);
    if (!$device) return false;

    return (int) $user->id === (int) $device->owner->id;
});
