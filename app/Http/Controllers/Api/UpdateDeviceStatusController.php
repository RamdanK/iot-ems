<?php

namespace App\Http\Controllers\Api;

use App\Events\DeviceStatusAccepted;
use App\Http\Requests\UpdateDeviceStatusRequest;
use App\Models\Device;

class UpdateDeviceStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateDeviceStatusRequest $request, Device $device)
    {
        if (!$device) {
            return $this->respondNotFound('Device not found!');
        }

        $status = $device->statuses()->create($request->safe()->merge(['date' => now(), 'time' => now()])->toArray());

        DeviceStatusAccepted::dispatch($status);

        return $this->respondWithSuccess($status);
    }
}
