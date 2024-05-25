<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => collect([
                'success' => $request->session()->get('success'),
                'danger' => $request->session()->get('danger'),
                'default' => $request->session()->get('default'),
                'warning' => $request->session()->get('warning'),
            ])
                ->filter(fn ($item) => $item !== null)
                ->toArray(),
        ];
    }
}
