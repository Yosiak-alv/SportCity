<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Client;
use App\Models\Coach;
use App\Models\Product;
use App\Models\System;
use App\Models\TrainingSession;
use App\Policies\User\RolePolicy;
use App\Policies\User\CoachPolicy;
use App\Policies\User\ClientPolicy;
use App\Policies\User\ProductPolicy;
use App\Models\User;
use App\Policies\User\UserPolicy;
use App\Policies\User\TrainingSessionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;

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
        TrainingSession::class => TrainingSessionPolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
