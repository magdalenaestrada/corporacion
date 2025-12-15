<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    \App\Models\Liquidacion::class => \App\Policies\LiquidacionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
{
    $this->registerPolicies();

    Gate::before(function ($user, $ability) {
        // ✅ Si el usuario tiene rol super-admin, autorizar todo
        return (method_exists($user, 'hasRole') && $user->hasRole('super-admin')) ? true : null;
    });
}
}
