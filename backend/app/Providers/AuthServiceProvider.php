<?php

namespace App\Providers;

use App\Models\Farm;
use App\Models\User;
use App\Models\Field;
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

        Gate::define('update-field', function (User $user, Field $field) {
            return $user->id === $field->farm->user_id;
        });

        Gate::define('update-product-in-magazine', function (User $user, Farm $farm) {
            return $user->id === $farm->user_id;
        });
    }
}
