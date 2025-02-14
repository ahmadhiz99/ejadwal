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
    // public function share(Request $request): array
    // {
    //     return [
    //         ...parent::share($request),
    //         'auth' => [
    //             'user' => $request->user(),
    //         ],
    //     ];
    // }
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            // Share authenticated user
            'auth' => [
                'user' => $request->user(),
            ],

            // Share validation errors
            'errors' => fn () => $request->session()->get('errors')
                ? $request->session()->get('errors')->getBag('default')->getMessages()
                : (object) [],

            // Share old input (for repopulating form fields)
            'old' => fn () => $request->session()->getOldInput(),
        ];
    }
}
