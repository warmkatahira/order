<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // システム管理者のみ許可
        Gate::define('admin-only', function ($user) {
            return ($user->role_id == 1);
        });
        // 発注以上（システム管理者＆発注）に許可
        Gate::define('order-higher', function ($user) {
            return ($user->role_id <= 12);
        });
    }
}
