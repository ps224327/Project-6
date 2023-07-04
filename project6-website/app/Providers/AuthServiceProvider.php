<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     */
    public function boot()
{
    $this->registerPolicies();

    Gate::define('webAdmin', function ($user) {
        return $user->role === 'webAdmin';
    });

    Gate::define('edit-employee', function ($user, $employee) {
        return $user->role === 'webAdmin';
    });

    Gate::define('create-employee', function ($user) {
        return $user->role === 'webAdmin';
    });

    Gate::define('delete-employee', function ($user, $employee) {
        return $user->role === 'webAdmin';
    });

    Gate::define('webEmployee', function ($user) {
        return $user->role === 'webEmployee';
    });

    Gate::define('view-products', function ($user) {
        return Gate::allows('webAdmin') || Gate::allows('webEmployee');
    });

    Gate::define('create-product', function ($user) {
        return Gate::allows('webAdmin') || Gate::allows('webEmployee');
    });

    Gate::define('edit-product', function ($user, $product) {
        return Gate::allows('webAdmin') || Gate::allows('webEmployee');
    });

    Gate::define('delete-product', function ($user, $product) {
        return Gate::allows('webAdmin') || Gate::allows('webEmployee');
    });
}

}
