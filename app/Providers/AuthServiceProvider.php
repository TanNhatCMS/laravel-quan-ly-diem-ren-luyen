<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class,
            \App\Http\Controllers\Admin\UserCrudController::class
        );
        $this->mergePolicies();
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies(): array
    {
        return [

        ];
    }

    protected function mergePolicies()
    {
//        config(['backpack.permissionmanager.policies.permission' => PermissionPolicy::class]);
//        config(['backpack.permissionmanager.policies.role' => RolePolicy::class]);
//        config(['backpack.permissionmanager.policies.user' => UserPolicy::class]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
