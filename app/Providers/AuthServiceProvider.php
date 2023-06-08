<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\System;
use App\Policies\User\ClientPolicy;
use App\Policies\User\SystemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Client::class => ClientPolicy::class,
        System::class => SystemPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
