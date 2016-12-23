<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        User::class  => UserPolicy::class,
        Status::class  => StatusPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
        $gate->define('status-destroy', function ($user, $status) {
          return $user->id === $status->user_id;
        });
        $gate->define('user-destroy', function ($currentUser, $user) {
          return $currentUser->is_admin && $currentUser->id !== $user->id;
        });
    }
}
