<?php

namespace App\Providers;

use App\School;
use App\Services\SchoolManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
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

        $this->app['db']->extend('school', function ($config, $name) use ($manager) {
            $school = $manager->getschool();

            if ($school) {
                $config['database'] = 'school_' . $school->id;
            }

            return $this->app['db.factory']->make($config, $name);
        });

        view()->composer('*', function ($view) use ($manager) {
            $view->school = $manager->getSchool();
        });

        Gate::before(function ($user, $school) {
            return $user->school->id == $school->id;
        });
        // Gate::before('view-school', function ($user) {
        //     dd(app(App\Services\SchoolManager::class));
        //     // return $user->school->id == $school->id;
        // });

        // Gate::define('view-school', function ($user, $school) {
        //     return $user->school->id == $school->id;
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('diffForHumans', function ($date) {
            return Carbon::parse($date)->diffForHumans();
            // return $date;
        });
        // Route::bind('school', function ($value) {
        //     return \App\School::where('slug', $value)->first();
        // });
        // View::composer('*', function ($view) {
        //     $view->school = request()->school;
        // });
    }
}
