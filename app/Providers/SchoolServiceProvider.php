<?php

namespace App\Providers;

use App\School;
use App\Services\SchoolManager;
use Illuminate\Support\ServiceProvider;

class SchoolServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $manager = new SchoolManager;

        $this->app->instance(SchoolManager::class, $manager);
        $this->app->bind(School::class, function () use ($manager) {
            return $manager->getSchool();
        });

        $this->app['db']->extends('tenant', function ($config, $name) use ($manager){
            $school = $manager->getSchool();

            if ($school) {
                $config['database'] = 'tenant_'.$school->id;
            }

            return $this->app['db.factory']->make($config, $name);
        });

        view()->composer('*', function ($view, $manager) {
            $view->tenant = $manager->getSchool();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
