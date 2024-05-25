<?php

namespace App\Actions;

use App\Http\DataTransferObjects\StoreEndpointData;
use App\Models\Endpoint;
use App\Models\User;
use Illuminate\Support\Str;

class StoreEndpointAction
{
    public function handle(StoreEndpointData $data, User $user): Endpoint
    {
        $key = $this->generateKey();

        return $user->endpoints()->create([
            ...$data->toArray(),
            'key' => $key,
            'url' => $this->generateEndpoint($key),
        ]);
    }

    public function generateKey(): string
    {
        $key = Str::random(8);

        while (Endpoint::where('key', $key)->exists()) {
            $key = Str::random(8);
        }

        return $key;
    }

    public function generateEndpoint(string $key): string
    {
        $key = $this->generateKey();

        while (Endpoint::where('key', $key)->exists()) {
            $key = $this->generateKey();
        }

        return route('api.endpoint', ['key' => $key]);
    }
}
