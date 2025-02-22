<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->tokenCan('device:update-status');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serialNumber' => 'string|required',
            'voltage1' => 'numeric',
            'current1' => 'numeric',
            'power1' => 'numeric',
            'energy1' => 'numeric',
            'freq1' => 'numeric',
            'pf1' => 'numeric',
            'voltage2' => 'numeric',
            'current2' => 'numeric',
            'power2' => 'numeric',
            'energy2' => 'numeric',
            'freq2' => 'numeric',
            'pf2' => 'numeric',
            'temp' => 'numeric',
            'battery' => 'numeric',
        ];
    }
}
