<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Coach;
use App\Models\Product;
use App\Models\System;
use App\Policies\User\CoachPolicy;
use App\Policies\User\ClientPolicy;
use App\Policies\User\ProductPolicy;
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
        Product::class =>ProductPolicy::class,
        Coach::class => CoachPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
