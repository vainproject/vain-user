<?php

namespace Modules\User\Providers;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;
use Modules\User\Entities\Guest;
use Modules\User\Entities\Permission;
use PDOException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        foreach ($this->getPermission() as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register a non-peristable guest entity
        $this->registerGuest();

        // Register a Gate which uses our guest
        // as part of its user resolver
        $this->registerAccessGate();
    }

    /**
     * Returns an empty error in case of non-existend database (i.e. when working with a newly deployed system).
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    protected function getPermission()
    {
        try {
            return Permission::with('roles')->get();
        } catch (PDOException $e) {
            Log::warning('Permission table could not be found when trying to load permissions in AuthServiceProvider');

            return [];
        }
    }

    /**
     * Register a guest representing user entity
     * which is not persistable
     */
    protected function registerGuest()
    {
        $this->app->bind('guest.abilities', function($app) {
            return ['*.show'];
        });

        $this->app->bind('guest', function($app) {
            return new Guest($app['guest.abilities']);
        });
    }

    /**
     * Register the access gate service.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new Gate($app, function () use ($app) {
                return $app['auth']->user() ?: $app['guest'];
            });
        });
    }
}
