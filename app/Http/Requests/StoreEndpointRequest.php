<?php

namespace App\Http\Requests;

use App\Http\DataTransferObjects\StoreEndpointData;
use Illuminate\Foundation\Http\FormRequest;

class StoreEndpointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'method' => ['required', 'string', 'in:get,post,put,patch,delete'],
            'status_code' => ['required', 'integer'],
            'delay' => ['nullable', 'integer', 'max:60'],
        ];
    }

    public function toData(): StoreEndpointData
    {
        return new StoreEndpointData($this->validated());
    }

    public function authorize(): bool
    {
        return true;
    }
}
