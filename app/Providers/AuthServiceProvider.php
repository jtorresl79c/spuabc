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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('ManejarUsuario', function($user){
            return $user->role == 'Administrador';
        });

        Gate::define('AccesoAdmin', function($user){
            return $user->role == 'Administrador';
        });
        Gate::define('AccesoAlmacenista', function($user){
            return $user->role == 'Almacenista'||$user->role == 'Administrador';
        });

        //
    }
}
