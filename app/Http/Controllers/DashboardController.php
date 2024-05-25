<?php

namespace App\Http\Controllers;

use App\Http\Resources\EndpointResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $endpoints = EndpointResource::collection(
            $request->user()->endpoints()->latest()->get()
        );

        return Inertia::render('Dashboard', [
            'endpoints' => fn () => $endpoints
        ]);
    }
}
