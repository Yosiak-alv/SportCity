<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

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

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user()?->makeHidden(['remember_token'])->load('gym:id,name,address'),
                'user_role_permissions' => $request?->user()?->getPermissionsViaRoles()->pluck('name'),
                'user_roles' => $request?->user()?->getRoleNames()
            ],
            /*  'flash' => function () use ($request) {
                return [
                    'type' => $request->session()->get('type'),
                    'message' => $request->session()->get('message'),
                    'level'  => $request->session()->get('level') 
                ];
            }, */
            'flash' =>[
                'level' => fn() => $request->session()->get('level'),
                'message' => fn() => $request->session()->get('message'),      
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
