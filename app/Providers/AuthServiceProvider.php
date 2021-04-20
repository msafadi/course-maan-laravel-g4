<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Models\Category' => 'App\Policies\CategoryPolicy',
        //'App\Models\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gates
        Gate::before(function($user, $ability) {
            if ($user->type == 'super-admin') {
                return true;
            }
        });

        Gate::define('posts.create', function($user) {
            return $user->role->abilities()->where('code', 'posts.create')->exists();
        });

        Gate::define('posts.update', function($user) {
            return $user->role->abilities()->where('code', 'posts.update')->exists();
        });

        Gate::define('posts.delete', function($user) {
            return $user->role->abilities()->where('code', 'posts.delete')->exists();
        });
    }
}
