<?php

namespace App\Http\Controllers;

use App\Models\Endpoint;
use Illuminate\Http\Request;

class InvokeEndpointController extends Controller
{
    public function __invoke(Request $request, Endpoint $endpoint)
    {
        $method = $request->method();

        if ($endpoint->method !== strtolower($method)) {
            return response([], 405)
                ->header('Content-Type', 'application/json');
        }

        if ($endpoint->delay) {
            $this->delay($endpoint->delay);
        }

        return response([], $endpoint->status_code)
            ->header('Content-Type', 'application/json');
    }

    public function delay(int $delay): void
    {
        sleep($delay);
    }
}
